<?php

use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use Illuminate\Database\Seeder;

class DescriptionsTableSeeder extends Seeder {

    private $configuration;
    private $defaultFilePath;

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run() {

        $this->configuration = \App::make('Interfaces\ConfigurationInterface');
        //the path for the default json data files
        $this->defaultFilePath = base_path() . '/database/json_data/';

        //all the tables that need seeding
        $tables = [
            'action_rating_attributes',
            'availability_freqs',
            'availability_time',
            'collaboration_types',
            'comm_method',
            'driver_license_types',
            'education_levels',
            'genders',
            'how_you_learned',
            'how_you_learned2',
            'identification_types',
            'language_levels',
            'languages',
            'marital_statuses',
            'rating_attributes',
            'step_statuses',
            'task_statuses',
            'volunteer_statuses',
            'volunteering_work_interests',
            'work_statuses',
        ];

        foreach ($tables as $table) {
            $this->addData($table);
        }

        //interest seeding needs a different mechanism
        $this->addInterests();

    }


    /**
     * Inserting data in the tables from the json files.
     * Use the default path if no override file exists.
     *
     * @param $table
     */
    private function addData($table) {

        //check is there's a dependency file overriding the default json data
        $filepath = $this->configuration->getJsonDataPath() . $table . '.json';

        //set the default path
        if (!\File::exists($filepath)) {
            $filepath = $this->defaultFilePath . $table . '.json';
        }

        //get the data from the file and insert them
        $json = \File::get($filepath);

        $data = json_decode($json);

        foreach ($data as $d) {
            \DB::table($table)->insert([
                ['description' => $d->description]
            ]);
        }
    }


    /**
     * A different mechanism for the interests, as they are connected
     * to an interest category.
     */
    private function addInterests() {

        $filepath = $this->configuration->getJsonDataPath() . 'interests.json';

        if (!\File::exists($filepath)) {
            $filepath = $this->defaultFilePath . 'interests.json';
        }

        $json = \File::get($filepath);

        $array = json_decode($json);
        $categories = $array->categories;

        foreach ($categories as $category) {
            $cat = InterestCategory::create([
                'description' => $category->description
            ]);

            foreach ($category->interests as $interest) {
                $int = Interest::create([
                    'category_id' => $cat->id,
                    'description' => $interest->description
                ]);
            }
        }
    }
}
