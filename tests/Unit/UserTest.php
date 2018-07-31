<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_has_many_file()
    {
        $user = factory(\App\User::class)->create();
        $file = factory(\App\File::class, 2)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->files());
    }

    /**
     * @test
     */
    // public function create_user_after_registration()
    // {
    //     $register_controller = new \App\Http\Controllers\Auth\RegisterController;
    //     $data = [
    //         'name' => 'Will',
    //         'email' => 'will@gmail.com',
    //         'password' => 'password'
    //     ];
    //     $user = $register_controller->create($data);
    //     $this->assertInstanceOf('\App\User', $user);
    // }
}
