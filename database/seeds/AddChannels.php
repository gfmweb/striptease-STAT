<?php

use Illuminate\Database\Seeder;

class AddChannels extends Seeder
{

    private $channels = [
        'Facebook',
        'Instagram',
        'VK',
        'Tik-Tok',
        'Одноклассники',
        'Яндекс Директ',
        'Google Adwords',
        'Виральность',
        'Партнёрка',
        'Радио',
        'ТВ',
        'PR',
        'Бумажный носитель',
        'Интернет порталы и карты',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Channels seeding...');
        foreach ($this->channels as $channel) {
            if (\App\Channel::query()->where('name', $channel)->exists()) {
                $this->command->info($channel . ' already exists!');
            } else {
                \App\Channel::query()->create([
                    'name' => $channel
                ]);
                $this->command->info($channel . ' created!');
            }
        }


    }
}
