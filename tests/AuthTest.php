<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;



class AuthTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * @test
     */
    public function a_user_may_register_for_an_account_but_must_confirm_their_email_address()
    {
        $this->visit('register')
             ->type('JohnDoe', 'name')
             ->type('john@example.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
            ->press('Register');

        $this->see('Please confirm your email address')
            ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 0]);

        $user = User::whereName('JohnDoe')->first();

        $this->login($user)->see('These credentials do not match our records.');

        $this->visit("register/confirm/{$user->token}")
            ->see('You are now confirmed. Please login.')
            ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 1]);

    }

    /**
     * @test
     */
    public function a_user_may_login()
    {
        $this->login()->see('Dashboard');
    }


    protected function login($user = null){

        $user = $user ?: factory('App\User')->create(['password' => 'password']);

        return $this->visit('login')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->press('Login');
    }

}
