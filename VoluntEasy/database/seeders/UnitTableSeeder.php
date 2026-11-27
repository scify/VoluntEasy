<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    private UnitService $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run()
    {
        $unit = Unit::create([
            'description' => 'Root',
            'comments' => 'Root unit',
        ]);

        $unit->steps()->saveMany($this->unitService->createSteps());

    }
}
