<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_can_browse_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200)->assertSee('Register');
    }

    /**
     * @test
     */
    public function guest_can_browse_forget_password_page()
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200)->assertSee('Reset Password');
    }

    /**
     * @test
     */
    public function guest_can_browse_reset_password_page()
    {
        $response = $this->get('/password/reset/aaa');
        $response->assertStatus(200)->assertSee('Reset Password');
    }

    /**
     * @test
     */
    public function guest_can_register()
    {
        $user = [
            'name' => 'Joe',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];
        $responce = $this->post('/register', $user);
        $responce->assertStatus(302)->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => 'Joe',
            'email' => 'testemail@test.com',
        ]);
    }
}
