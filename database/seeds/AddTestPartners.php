<?php

use Illuminate\Database\Seeder;

class AddTestPartners extends Seeder
{

    private $partners = [
        'Прайд',
        'Айдитон',
        'Колаб',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Partners seeding...');
        foreach ($this->partners as $partner) {
            if (\App\Partner::query()->where('name', $partner)->exists()) {
                $this->command->info($partner . ' already exists!');
            } else {
                \App\Partner::query()->create([
                    'name' => $partner
                ]);
                $this->command->info($partner . ' created!');
            }
        }


    }
}
