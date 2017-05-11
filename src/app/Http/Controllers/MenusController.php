<?php
namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Http\Requests\CategoryEdit;
use Afrittella\BackProject\Repositories\Menus;
use Afrittella\BackProject\Repositories\Permissions;
use Illuminate\Http\Request;
use Afrittella\BackProject\Http\Requests\CategoryAdd;
use Prologue\Alerts\Facades\Alert;

class MenusController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Menus $menus)
    {
        return view('back-project::menus.index')->with('menus', $menus->transform($menus->all()));
    }

    public function edit(Request $request, Menus $menus, Permissions $permissions, $id)
    {
        return view('back-project::menus.edit')
                    ->with([
                        'menu' => $menus->find($id),
                        'children' => $menus->children($id),
                        'permissions' =>  $permissions->all()
                    ]);
    }

    public function create(Permissions $permissions)
    {
        return view('back-project::menus.create')
            ->with([
                'permissions' =>  $permissions->all()
            ]);
    }

    public function delete(Menus $menus, $id)
    {
        $menus->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::menus.menu')]))->flash();

        return back();
    }

    public function up(Request $request, Menus $menus, $id)
    {
        $menus->moveUp($id);
        return back();
    }

    public function down(Request $request, Menus $menus, $id)
    {
        $menus->moveDown($id);
        return back();
    }

    public function store(CategoryAdd $request, Menus $menus, Permissions $permissions)
    {
        $menu = $menus->create($request->all());
        $permission = $request->input('permission');

        if (!empty($permission))
        {
            $permissions->firstOrCreate($permission);
        }

        Alert::add('success', trans('back-project::crud.model_created', ['model' => trans('back-project::menus.menu')]))->flash();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json();
        } else {
            return redirect(route('menus.index'));
        }
    }

    public function update(CategoryEdit $request, Menus $menus, $id)
    {
        $menu = $menus->update($request->all(), $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::menus.menu')]))->flash();

        return back();
    }
}