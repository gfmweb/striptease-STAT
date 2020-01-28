<?php

use Illuminate\Database\Seeder;

class AddTestProjects extends Seeder
{

    private $projects = [
        'Жека спорит',
        'Цепочка №1',
        'Цепочка №2',

    ];

    private $subProjects = [
        'Лайт' => 'bur-club.ru',
        'Хард' => 'shahki_bv.ru	'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Projects seeding...');
        foreach ($this->projects as $project) {
            if (\App\Project::query()->where('name', $project)->exists()) {
                $this->command->info($project . ' already exists!');
            } else {
                $new = \App\Project::query()->create([
                    'name'       => $project,
                    'city_id'    => \App\City::query()->first()->id,
                ]);

                $this->command->info($project . ' created!');
            }
        }

        $project = \App\Project::query()->first();
        if ($project) {
            foreach ($this->subProjects as $name => $url)
                \App\SubProject::query()->create([
                    'name'       => $name,
                    'url'        => $url,
                    'project_id' => $project->id,
                    'partner_id' => \App\Partner::query()->first()->id,
                ]);
            $this->command->info('SubProjects also created!');
        }
    }
}
