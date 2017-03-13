<?php

namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Facades\MediaManager;
use Afrittella\BackProject\Repositories\Attachments;
use Afrittella\BackProject\Repositories\Criteria\Attachments\All;
use Afrittella\BackProject\Repositories\Criteria\Attachments\ByUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Attachments $attachments)
    {
        $attachments->pushCriteria(new All());
        return view('back-project::media.index')->with('attachments', $attachments->all());
    }

    public function edit(Attachments $attachments, $id)
    {
        return view('back-project::media.edit')->with('attachment', $attachments->find($id));
    }

    public function store(Request $request, Attachments $attachments)
    {
        $user = Auth::user();

        $success = $attachments->create(array_merge($request->all(), ['user_id' => $user->id]));

        Alert::add('success', trans('back-project::base.image_uploaded'))->flash();

        return response()->json([
            'success' => true,
            'message' => trans('back-project::base.image_uploaded')
        ]);

    }

    public function update(Request $request, Attachments $attachments, $id)
    {

        $attachment = $attachments->update($request->all(), $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::media.image')]))->flash();

        return redirect(route('media.index'));
    }

    public function delete(Attachments $attachments, $id)
    {
        $attachments->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::media.image')]))->flash();

        return back();
    }
}