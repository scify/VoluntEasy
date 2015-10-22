<?php

use App\Models\Descriptions\AvailabilityFrequencies;
use App\Models\Descriptions\HowYouLearned;
use App\Models\Descriptions\Interest;
use App\Models\Descriptions\InterestCategory;
use App\Models\Rating\RatingAttribute;
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
        $this->addAvailabilityFrequencies();
        $this->addHowYouLearned();

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

            \DB::table('ratings')->delete();

            $json = \File::get($this->configuration->getRatingsJsonPath());

            $ratings = json_decode($json);

            foreach ($ratings as $rating) {
                RatingAttribute::create([
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

}
