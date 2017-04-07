<?php

namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Http\Requests\PermissionAdd;
use Afrittella\BackProject\Http\Requests\PermissionEdit;
use Afrittella\BackProject\Repositories\Permissions;
use Afrittella\BackProject\Repositories\Roles;
use Prologue\Alerts\Facades\Alert;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Permissions $permissions)
    {
        return view('back-project::permissions.index')->with('permissions', $permissions->transform($permissions->all()));
    }

    public function edit(Permissions $permissions, Roles $roles, $id)
    {
        return view('back-project::permissions.edit')->with('permission', $permissions->find($id))->with('roles', $roles->all());
    }

    public function update(PermissionEdit $request, Permissions $permissions, $id)
    {
        $permission = $permissions->update($request->all(), $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::permissions.permission')]))->flash();

        return redirect(route('permissions.index'));
    }

    public function create(Permissions $permissions, Roles $roles)
    {
        return view('back-project::permissions.create')->with('roles', $roles->all());
    }

    public function store(PermissionAdd $request, Permissions $permissions)
    {
        $permission = $permissions->create($request->all());

        Alert::add('success', trans('back-project::crud.model_created', ['model' => trans('back-project::permissions.permission')]))->flash();

        return redirect(route('permissions.index'));
    }

    public function delete(Permissions $permissions, $id)
    {
        $permissions->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::permissions.permission')]))->flash();

        return back();
    }
}