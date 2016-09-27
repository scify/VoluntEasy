<?php

use App\Models\Descriptions\Interest;
use Illuminate\Database\Seeder;

class UpdateInterests extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interest = Interest::create(['description' => 'health', 'category_id' => 1]);
        $interest->save();
    }
}
