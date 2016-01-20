<?php

use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\HowYouLearned;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use App\Models\Rating\RatingAttribute;
use  App\Models\Rating\ActionRatingAttribute;
use \App\Models\Descriptions\DriverLicenceType;
use Illuminate\Database\Seeder;

class DescriptionsTableSeeder extends Seeder {

    private $configuration;

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run() {

        $this->configuration = \App::make('Interfaces\ConfigurationInterface');

        $this->addInterests();
        $this->addRatings();
        $this->addActionRatings();
        $this->addAvailabilityFrequencies();
        $this->addHowYouLearned();
        $this->addCollaborationTypes();
        $this->addDriverLicenceTypes();
        $this->addTaskStatuses();

    }


    private function addInterests() {

        if (!empty($this->configuration->getInterestsJsonPath()) && file_exists($this->configuration->getInterestsJsonPath())) {
            \DB::table('interests')->delete();
            \DB::table('interest_categories')->delete();

            $json = \File::get($this->configuration->getInterestsJsonPath());

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

    private function addRatings() {

        if (!empty($this->configuration->getRatingsJsonPath()) && file_exists($this->configuration->getRatingsJsonPath())) {

            \DB::table('rating_attributes')->delete();

            $json = \File::get($this->configuration->getRatingsJsonPath());

            $ratings = json_decode($json);

            foreach ($ratings as $rating) {
                RatingAttribute::create([
                    'description' => $rating->description
                ]);
            }
        }
    }

    private function addActionRatings() {

        if (!empty($this->configuration->getActionRatingsJsonPath()) && file_exists($this->configuration->getActionRatingsJsonPath())) {

            \DB::table('action_rating_attributes')->delete();

            $json = \File::get($this->configuration->getActionRatingsJsonPath());

            $ratings = json_decode($json);

            foreach ($ratings as $rating) {
               ActionRatingAttribute::create([
                    'description' => $rating->description
                ]);
            }
        }
    }

    private function addAvailabilityFrequencies() {

        if (!empty($this->configuration->getAvailabilityFrequenciesJsonPath()) && file_exists($this->configuration->getAvailabilityFrequenciesJsonPath())) {

            \DB::table('availability_freqs')->delete();

            $json = \File::get($this->configuration->getAvailabilityFrequenciesJsonPath());

            $freqs = json_decode($json);

            foreach ($freqs as $freq) {
                AvailabilityFrequencies::create([
                    'description' => $freq->description
                ]);
            }
        }
    }

    private function addHowYouLearned() {

        if (!empty($this->configuration->getHowYouLearnedJsonPath()) && file_exists($this->configuration->getHowYouLearnedJsonPath())) {

            \DB::table('how_you_learned')->delete();

            $json = \File::get($this->configuration->getHowYouLearnedJsonPath());

            $hows = json_decode($json);

            foreach ($hows as $how) {
                HowYouLearned::create([
                    'description' => $how->description
                ]);
            }
        }
    }

    private function addCollaborationTypes() {
        // Collaboration types.
        \DB::table('collaboration_types')->delete();

        $collaboration_types = [
            ['description' => 'ΜΚΟ'],
            ['description' => 'Δημόσιος Φορέας'],
            ['description' => 'Ιδιωτικός Φορέας'],
            ['description' => 'Άλλο'],
        ];

        \DB::table('collaboration_types')->insert($collaboration_types);
    }

    private function addDriverLicenceTypes() {

        if (!empty($this->configuration->getDriverLicenceTypesJsonPath()) && file_exists($this->configuration->getDriverLicenceTypesJsonPath())) {

            \DB::table('driver_license_types')->delete();

            $json = \File::get($this->configuration->getDriverLicenceTypesJsonPath());

            $types = json_decode($json);

            foreach ($types as $type) {
                DriverLicenceType::create([
                    'description' => $type->description
                ]);
            }
        }
        else{
            DB::table('driver_license_types')->delete();

            $license_types = [
                ['description' => 'Χωρίς δίπλωμα'],
                ['description' => 'Α κατηγορίας'],
                ['description' => 'A1 κατηγορίας'],
                ['description' => 'Β κατηγορίας'],
                ['description' => 'Γ κατηγορίας'],
                ['description' => 'Γ+Ε κατηγορίας'],
            ];

            DB::table('driver_license_types')->insert($license_types);
        }
    }

    private function addTaskStatuses() {
        // Task statuses.

        $data = [
            ['name' => 'To Do'],
            ['name' => 'Doing'],
            ['name' => 'Done'],
        ];

        \DB::table('task_statuses')->insert($data);
    }

}
