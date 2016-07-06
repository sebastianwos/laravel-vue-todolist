<?php

namespace App\Http\Controllers\Auth;


use App\User;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * @var AppMailer
     */
    private $mailer;

    /**
     * Create a new authentication controller instance.
     * @param AppMailer $mailer
     */
    public function __construct( AppMailer $mailer )
    {

        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->mailer = $mailer;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    /**
     * @param User $user
     */
    protected function sendConfirmationEmailTo(User $user){

        $this->mailer->sendConfirmationEmailTo($user);

    }

    public function confirmEmail( $token ){

        User::whereToken($token)->firstOrFail()->confirmEmail();
        flash('You are now confirmed. Please login.');

        return redirect('login');

    }

    public function authenticated(){
        return redirect()->intended('/tasks');
    }

    public function getCredentials(Request $request){
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'verified' => true,
        ];
    }

}
