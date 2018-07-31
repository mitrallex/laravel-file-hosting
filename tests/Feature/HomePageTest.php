<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_authenticated_user_can_not_browse_home_page()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_browse_home_page()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function an_authenticated_user_redirect_to_home_page()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);
        $response = $this->get(route('login'));
        $response->assertStatus(302)->assertRedirect(route('home'));
    }
}
