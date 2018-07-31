<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_authenticated_user_can_not_fetch_files()
    {
        $response = $this->get(action('FileController@index', ['images']));
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /**
     * @test
     */

    public function an_authenticated_user_can_fetch_files()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $response = $this->get(action('FileController@index', ['image']));
        // dd($response);
        $response->assertStatus(200)
                ->assertJsonFragment([
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $file->type,
                    'extension' => $file->extension
                ]);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_fetch_a_specific_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $response = $this->get(action('FileController@index', ['image', $file->id]));
        // dd($response);
        $response->assertStatus(200)
                ->assertJson([
                    'id' => $file->id,
                    'name' => $file->name,
                    'type' => $file->type,
                    'extension' => $file->extension
                ]);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_store_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->make([
            'type' => 'image',
            'extension' => 'jpg'
        ])->toArray();

        Storage::fake('local');

        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' .$file['name'] . '.jpg';
        $uploaded_file = UploadedFile::fake()->image($uploaded_file_name);
        $file['file'] = $uploaded_file;

        $response = $this->post(action('FileController@store'), $file);

        $response->assertStatus(200);
        Storage::disk('local')->assertExists($uploaded_file_name);
        $this->assertDatabaseHas('files', [
            'id' => 1,
            'name' => $file['name'],
            'type' => $file['type'],
            'extension' => $file['extension'],
            'user_id' => $user->id
        ]);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_edit_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $new_file = factory(\App\File::class)->make([
            'id' => $file->id,
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        Storage::fake('local');

        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' . $file['name'] . '.jpg';
        $uploaded_file = UploadedFile::fake()->image($uploaded_file_name);
        $file->upload($file->type, $uploaded_file, $file->name, $file->extension);

        $response = $this->post(action('FileController@edit', $new_file->toArray()));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('files', $file->toArray());
        $this->assertDatabaseHas('files', $new_file->toArray());
    }

    /**
     * @test
     */
    public function an_authenticated_user_fail_to_edit_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $new_file = factory(\App\File::class)->make([
            'id' => $file->id,
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        Storage::fake('local');

        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' . $file['name'] . '.jpg';
        $uploaded_file = UploadedFile::fake()->image($uploaded_file_name);

        $response = $this->post(action('FileController@edit', $new_file->toArray()));
        $response->assertStatus(200);
        $this->assertFalse($response->original);
    }

    /**
     * @test
     */
    public function an_authenticated_user_give_the_same_file_name_to_edit_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $new_file = factory(\App\File::class)->make([
            'id' => $file->id,
            'name' => $file->name,
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        Storage::fake('local');

        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' . $file['name'] . '.jpg';
        $uploaded_file = UploadedFile::fake()->image($uploaded_file_name);

        $response = $this->post(action('FileController@edit', $new_file->toArray()));
        $response->assertStatus(200);
        $this->assertFalse($response->original);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_remove_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        Storage::fake('local');

        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' .$file['name'] . '.jpg';
        $uploaded_file = UploadedFile::fake()->image($uploaded_file_name);
        $file->upload($file->type, $uploaded_file, $file->name, $file->extension);

        $response = $this->post(action('FileController@destroy', 1));

        $response->assertStatus(200);
        Storage::disk('local')->assertMissing($uploaded_file_name);
        $this->assertDatabaseMissing('files', [
            'id' => $file->id,
            'name' => $file->name,
            'type' => $file->type,
            'extension' => $file->extension,
            'user_id' => $user->id
        ]);
    }

    /**
     * @test
     */
    public function an_authenticated_user_fail_to_remove_file()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        Storage::fake('local');
        $user_dir = $user->name . '_' .$user->id;
        $uploaded_file_name = 'public/' . $user_dir. '/' . $file['type'] . '/' .$file['name'] . '.jpg';

        $response = $this->post(action('FileController@destroy', 1));

        $response->assertStatus(200);
        $this->assertFalse($response->original);
        Storage::disk('local')->assertMissing($uploaded_file_name);
    }
}
