<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply middleware to restrict access to authenticated users
        $this->middleware('guest')->except('logout');
        // Apply middleware to restrict access to the logout method
        $this->middleware('auth')->only('logout');
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request The current HTTP request instance.
     * @return RedirectResponse Redirect response to the login route.
     */
    protected function logout(Request $request): RedirectResponse
    {
        // Invalidate the session and regenerate it
        $this->guard()->logout();
        // Flush the session data
        $request->session()->flush();
        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();
        // Redirect to the login route
        return redirect()->route('login');
    }
}
