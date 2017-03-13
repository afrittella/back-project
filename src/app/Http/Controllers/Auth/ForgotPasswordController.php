<?php
namespace Afrittella\BackProject\Http\Controllers\Auth;

use Afrittella\BackProject\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    protected $data = []; // the information we send to the view

    use SendsPasswordResetEmails;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $this->data['title'] = trans('back-project::base.reset_password'); // set the page title
        return view('back-project::auth.passwords.email', $this->data);
    }
}
