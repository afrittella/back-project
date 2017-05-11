<?php

namespace Afrittella\BackProject\Http\Controllers;

use Afrittella\BackProject\Exceptions\NotFoundException;
use Afrittella\BackProject\Http\Requests\AttachmentAdd;
use Afrittella\BackProject\Repositories\Attachments;
use Afrittella\BackProject\Repositories\Criteria\Attachments\ByUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class AttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Attachments $attachments)
    {
        // pushCriteria is a method from Repository Pattern
        $attachments->pushCriteria(new ByUser());
        return view('back-project::attachments.index')->with('attachments', $attachments->all());
    }


    /**
     * @param Attachments $attachments
     * @param $id
     * @return $this
     */
    public function edit(Attachments $attachments, $id)
    {
        $attachment = $attachments->find($id);

        $this->bCAuthorize('update', $attachment);

        return view('back-project::attachments.edit')->with('attachment', $attachment);
    }

    public function store(AttachmentAdd $request, Attachments $attachments)
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
        $attachment = $attachments->find($id);

        $this->bCAuthorize('update', $attachment);

        $attachment = $attachments->update($request->all(), $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::media.image')]))->flash();

        return redirect(route('attachments.index'));
    }

    public function delete(Attachments $attachments, $id)
    {
        $attachment = $attachments->find($id);

        $this->bCAuthorize('delete', $attachment);

        $attachments->delete($id);

        Alert::add('success', trans('back-project::crud.model_deleted', ['model' => trans('back-project::media.image')]))->flash();

        return back();
    }

    public function setMain(Attachments $attachments, $id)
    {
        $attachment = $attachments->find($id);

        $this->bCAuthorize('update', $attachment);

        $data = [
            'is_main' => 1
        ];

        $attachments->update($data, $id);

        Alert::add('success', trans('back-project::crud.model_updated', ['model' => trans('back-project::media.image')]))->flash();

        return redirect(route('attachments.index'));
    }
}