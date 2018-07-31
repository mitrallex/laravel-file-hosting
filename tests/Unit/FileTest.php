<?php

namespace Tests\Unit;

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
    public function file_has_an_owner()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
        ]);
        $this->assertInstanceOf('App\User', $file->user);
    }

    /**
     * @test
     */
    public function  get_max_filesize()
    {
        $max_filesize = (int)ini_get('upload_max_filesize') * 1000;
        $this->assertEquals($max_filesize, \App\File::getMaxSize());
    }

    /**
     * @test
     */
    public function get_user_directory()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->name . '_' . $user->id, $file->getUserDir());
    }

    /**
     * @test
     */
    public function get_file_name()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
            'user_id' => $user->id
        ]);

        $user_file_name = 'public/' . $file->getUserDir() . '/' . $file->type . '/' . $file->name . '.' . $file->extension;

        $this->assertEquals($user_file_name, $file->getName($file->type, $file->name, $file->extension));
    }

    /**
     * @test
     */
    public function get_image_file_type_by_extension()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'image',
            'extension' => 'jpg',
        ]);

        $this->assertEquals($file->type, $file->getType($file->extension));
    }

    /**
     * @test
     */
    public function get_audio_file_type_by_extension()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'audio',
            'extension' => 'mp3',
        ]);

        $this->assertEquals($file->type, $file->getType($file->extension));
    }

    /**
     * @test
     */
    public function get_video_file_type_by_extension()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'video',
            'extension' => 'mp4',
        ]);

        $this->assertEquals($file->type, $file->getType($file->extension));
    }

    /**
     * @test
     */
    public function get_document_file_type_by_extension()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'document',
            'extension' => 'docx',
        ]);

        $this->assertEquals($file->type, $file->getType($file->extension));
    }

    /**
     * @test
     */
    public function get_undeifned_file_type_by_extension()
    {
        $file = factory(\App\File::class)->create([
            'type' => 'undefined',
            'extension' => 'mmm'
        ]);

        $this->assertNull($file->getType($file->extension));
    }

    /**
     * @test
     */
    public function get_all_allowing_file_extensions()
    {
        $extensions_arr = array_merge(\App\File::$image_ext,
                                    \App\File::$audio_ext,
                                    \App\File::$video_ext,
                                    \App\File::$document_ext);
        $this->assertEquals(implode(',', $extensions_arr), \App\File::getAllExtensions());
    }

    /**
     * @test
     */
    public function file_successfully_uploaded()
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
        $file->file = $uploaded_file;

        $this->assertEquals($uploaded_file_name, $file->upload($file->type, $file->file, $file->name, $file->extension));
    }
}
