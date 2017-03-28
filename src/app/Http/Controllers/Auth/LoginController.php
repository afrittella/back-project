<?php
namespace Afrittella\BackProject\Http\Controllers\Auth;

//use Afrittella\BackProject\app\Http\Controllers\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers {
      logout as defaultLogout;
    }

    public function __construct()
    {
      $this->middleware('guest', ['except' => 'logout']);
      // ----------------------------------
      // Use the admin prefix in all routes
      // If not logged in redirect here.
      $this->loginPath = property_exists($this, 'loginPath') ? $this->loginPath
          : config('back-project.route_prefix', 'admin').'/login';
      // Redirect here after successful login.
      $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
          : config('back-project.route_prefix', 'admin').'/dashboard';
      // Redirect here after logout.
      $this->redirectAfterLogout = property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout
          : '/';
      // ----------------------------------
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $this->data['title'] = trans('back-project::base.login'); // set the page title
        return view('back-project::auth.login', $this->data);
    }

    /**
     * Log the user out and redirect him to specific location.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Do the default logout procedure
        $this->defaultLogout($request);
        // And redirect to custom location
        return redirect($this->redirectAfterLogout);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['confirmed' => 1, 'is_social' => 0]);
    }
}
