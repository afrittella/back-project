<?php
namespace Afrittella\BackProject\Http\Controllers\Auth;

use Afrittella\BackProject\Http\Controllers\Controller;
use Afrittella\BackProject\Repositories\Users;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;
use Afrittella\BackProject\Events\UserRegistered as Registered;
use Prologue\Alerts\Facades\Alert;


class RegisterController extends Controller
{

    protected $data = []; // the information we send to the view

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
        // Where to redirect users after login / registration.

        $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
            : config('back-project.route_prefix', 'dashboard');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        //if registration is closed, deny access
        if (!config('back-project.registration_open')) {
            abort(403, trans('back-project::base.registration_closed'));
        }
        $this->data['title'] = trans('back-project::base.register'); // set the page title
        return view('back-project::auth.register', $this->data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request, Users $users)
    {
        // if registration is closed, deny access
        if (!config('back-project.registration_open')) {
            abort(403, trans('back-project::base.registration_closed'));
        }
        $this->validator($request->all())->validate();
        //$this->guard()->login($this->create($request->all()));
        $user = $users->create($request->all());

        event(new Registered($user->id));

        if ($users->getModel()->count() == 1) {
            $user->assignRole('administrator');
        } else {
            $user->assignRole('user');
        }

        Alert::add('success', trans('back-project::base.registration_email'))->flash();

        return redirect(route('login'));
    }

    public function validator(array $data)
    {
        $user_model = config('back-project.user_model');
        $user = new $user_model;
        $users_table = $user->getTable();

        return Validator::make($data, [
        'username' => 'required|max:255|unique:'.$users_table,
        'email' => 'required|email|max:255|unique:'.$users_table,
        'password' => 'required|min:6|confirmed'
        ]);
    }

    public function confirm(Users $users, $code, $username) {
        if ($users->findBy('username', $username)->confirm($code)) {
            Alert::add('success', trans('back-project::base.user_confirmed'))->flash();
        } else {
            Alert::add('error', trans('back-project::base.user_not_confirmed'))->flash();
        }

        return redirect(route('login'));
    }
}
