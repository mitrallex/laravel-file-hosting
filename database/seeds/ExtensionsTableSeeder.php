<?php

use Illuminate\Database\Seeder;

class ExtensionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extensions')->insert([
            [
                'format' => 'jpg',
                'type_id' => 1
            ],
            [
                'format' => 'png',
                'type_id' => 1
            ],
            [
                'format' => 'mp3',
                'type_id' => 2
            ],
            [
                'format' => 'mp4',
                'type_id' => 3
            ],
            [
                'format' => 'docx',
                'type_id' => 4
            ]
        ]);
    }
}
