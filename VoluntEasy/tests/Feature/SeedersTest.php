<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SeedersTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_database_seeds_without_mysql_non_strict_mode(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, DB::table('users')->count(), 'the admin user');
        $this->assertGreaterThan(0, DB::table('genders')->count());
        $this->assertGreaterThan(0, DB::table('how_you_learned')->count());
        $this->assertSame(1, DB::table('units')->whereNull('parent_unit_id')->count(), 'the root unit');
    }
}
