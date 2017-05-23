<?php

namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Http\Requests\RoleAdd;
use Afrittella\BackProject\Http\Requests\RoleEdit;
use Afrittella\BackProject\Repositories\Permissions;
use Afrittella\BackProject\Repositories\Roles;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Roles $roles)
    {
        return view('back-project::roles.index')->with('roles', $roles->transform($roles->all()));
    }

    public function edit(Roles $roles, Permissions $permissions, $id)
    {
        return view('back-project::roles.edit')->with('role', $roles->find($id))->with('permissions', $permissions->all());
    }

    public function update(RoleEdit $request, Roles $roles, $id)
    {
        $role = $roles->update($request->all(), $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::roles.role')]))->flash();

        return redirect(route('bp.roles.index'));
    }

    public function create(Permissions $permissions)
    {
        return view('back-project::roles.create')->with('permissions',  $permissions->all());
    }

    public function store(RoleAdd $request, Roles $roles)
    {
        $role= $roles->create($request->all());

        Alert::add('success', trans('back-project::crud.model_created', ['model' => trans('back-project::roles.role')]))->flash();

        return redirect(route('bp.roles.index'));
    }

    public function delete(Roles $roles, $id)
    {
        $roles->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::roles.role')]))->flash();

        return back();
    }
}