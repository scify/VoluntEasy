<?php

namespace Database\Seeders;

use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use Illuminate\Database\Seeder;

class DescriptionsTableSeeder extends Seeder
{
    private $configuration;

    private $defaultFilePath;

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {

        $this->configuration = \App::make('Interfaces\ConfigurationInterface');
        // the path for the default json data files
        $this->defaultFilePath = base_path().'/database/json_data/';

        // all the tables that need seeding
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
            'volunteering_departments',
            'work_statuses',
            'opa_labor_skills',
            'opa_interpersonal_skills',
        ];

        foreach ($tables as $table) {
            $this->addData($table);
        }

        // interest seeding needs a different mechanism
        $this->addInterests();

    }

    /**
     * Inserting data in the tables from the json files.
     * Use the default path if no override file exists.
     */
    private function addData($table)
    {

        // check is there's a dependency file overriding the default json data
        $filepath = $this->configuration->getJsonDataPath().$table.'.json';

        // set the default path
        if (! \File::exists($filepath)) {
            $filepath = $this->defaultFilePath.$table.'.json';
        }

        // get the data from the file and insert them
        $json = \File::get($filepath);

        $data = json_decode($json);

        $defaults = $this->requiredColumnDefaults($table);

        foreach ($data as $d) {
            \DB::table($table)->insert(['description' => $d->description] + $defaults);
        }
    }

    /**
     * Empty values for the NOT NULL columns (other than "description") that
     * have no default value. MySQL non-strict mode did this silently; strict
     * mode and SQLite need the values.
     *
     * @return array<string, string>
     */
    private function requiredColumnDefaults(string $table): array
    {
        $defaults = [];
        foreach (\Schema::getColumns($table) as $column) {
            if (! $column['nullable'] && $column['default'] === null && ! $column['auto_increment']
                && ! in_array($column['name'], ['description', 'created_at', 'updated_at'], true)) {
                $defaults[$column['name']] = '';
            }
        }

        return $defaults;
    }

    /**
     * A different mechanism for the interests, as they are connected
     * to an interest category.
     */
    private function addInterests()
    {

        $filepath = $this->configuration->getJsonDataPath().'interests.json';

        if (! \File::exists($filepath)) {
            $filepath = $this->defaultFilePath.'interests.json';
        }

        $json = \File::get($filepath);

        $array = json_decode($json);
        $categories = $array->categories;

        foreach ($categories as $category) {
            $cat = InterestCategory::create([
                'description' => $category->description,
            ]);

            foreach ($category->interests as $interest) {
                $int = Interest::create([
                    'category_id' => $cat->id,
                    'description' => $interest->description,
                ]);
            }
        }
    }
}
