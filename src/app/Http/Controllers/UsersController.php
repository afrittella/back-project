<?php

namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Http\Requests\AccountStore;
use Afrittella\BackProject\Http\Requests\AccountEdit;
use Afrittella\BackProject\Repositories\Users;
use Afrittella\BackProject\Repositories\Roles;
use Afrittella\BackProject\Http\Requests\UserAdd;
use Afrittella\BackProject\Http\Requests\UserEdit;
use Afrittella\BackProject\Events\UserRegistered as Registered;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show all users
     */
    public function index(Users $users)
    {
        return view('back-project::users.index')->with('users', $users->transform($users->all()));
    }

    public function edit(Users $users, Roles $roles, $id)
    {
        return view('back-project::users.edit')->with('user', $users->find($id))->with('roles', $roles->all());
    }

    public function account()
    {
        $user = Auth::user();

        return view('back-project::users.account')->with('user', Auth::user());
    }

    public function update(UserEdit $request, Users $users, $id)
    {
        $user = $users->update($request->all(), $id);

        //$users->findBy('id', $id)->roles()->sync($request->input('roles'));

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::users.user')]))->flash();

        return redirect(route('bp.users.index'));
    }

    public function create(Roles $roles)
    {
        return view('back-project::users.create')->with('roles', $roles->all());
    }

    public function store(UserAdd $request, Users $users)
    {
        $user = $users->create($request->all());

        event(new Registered($user->id));

        //$user->assignRole('user');

        Alert::add('success', trans('back-project::crud.model_created', ['model' => trans('back-project::users.user')]))->flash();

        return redirect(route('bp.users.index'));
    }

    public function accountStore(AccountStore $request, Users $users)
    {
        $id = Auth::user()->id;



        $data = array_merge($request->all(), [
            'is_social' => 0,
            'confirmed' => 1
        ]);

        $users->update($data, $id);

        if ($request->method() == 'POST') {
            Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::users.user')]))->flash();
        } else {
            Alert::add('success', trans('back-project::crud.model_created', ['model' => trans('back-project::users.user')]))->flash();
        }


        return redirect(route('bp.admin.dashboard'));
    }

    public function delete(Users $users, $id)
    {
        $users->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::users.user')]))->flash();

        return back();
    }
}