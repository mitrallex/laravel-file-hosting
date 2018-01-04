<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            ['name' => 'image'],
            ['name' => 'audio'],
            ['name' => 'video'],
            ['name' => 'document'],
        ]);
    }
}
