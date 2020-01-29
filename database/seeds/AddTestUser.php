<?php

use Illuminate\Database\Seeder;

class AddTestUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Test (user) connected...');
        if (\App\User::query()->where('name', 'Test')->exists()) {
            $this->command->info('Test already exists!');
        } else {
            $vargo           = new \App\User();
            $vargo->name     = 'Test';
            $vargo->login    = 'test';
            $vargo->password = bcrypt('7654321');
            $vargo->save();
            $this->command->info('Test created!');
        }

    }
}
