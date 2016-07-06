<?php


use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class SettingsTest extends TestCase{


    use DatabaseTransactions;


    /**
     * @test
     */
    public function a_user_may_change_password(){

        $user = factory(App\User::class)->create(['password' => 'password']);

        $this->assertTrue(Hash::check('password', $user->password));

        $this
            ->actingAs($user)
            ->visit('settings')
            ->type('password', 'oldpassword')
            ->type('password123', 'password')
            ->type('password123', 'password_confirmation')
            ->press('Change password')
            ->see('Password was changed');


    }

}