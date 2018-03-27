<?php

use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            'name' => 'смс',
            'type' => 'sms',
        ]);

        DB::table('channels')->insert([
            'name' => 'Телеграм',
            'type' => 'telegram',
        ]);

        DB::table('channels')->insert([
            'name' => 'Эл. почта',
            'type' => 'email',
        ]);
    }
}
