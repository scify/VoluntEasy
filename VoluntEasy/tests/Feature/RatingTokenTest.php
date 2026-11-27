<?php

namespace Tests\Feature;

use App\Models\Action;
use App\Models\Unit;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The rating pages are public and reached with the token of an e-mail. The
 * token decides which rating is stored, and it can be used only once.
 */
class RatingTokenTest extends TestCase
{
    use RefreshDatabase;

    private Action $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->action = Action::create([
            'description' => 'Beach clean-up', 'comments' => '', 'start_date' => '2030-01-01', 'end_date' => '2030-01-02',
            'unit_id' => Unit::firstOrFail()->id,
        ]);
    }

    public function test_an_action_rating_needs_a_valid_token_and_is_stored_once(): void
    {
        DB::table('action_scores')->insert(['token' => 'secret-token', 'comments' => '', 'rated' => false, 'action_id' => $this->action->id]);
        $attribute = DB::table('action_rating_attributes')->value('id');
        $data = ['ratings' => [['attrId' => $attribute, 'score' => 4]], 'comments' => 'Well organised'];

        $this->post('/ratings/action/store', $data + ['token' => 'wrong'])->assertNotFound();
        $this->post('/ratings/action/store', $data)->assertNotFound();

        $this->post('/ratings/action/store', $data + ['token' => 'secret-token'])
            ->assertOk()->assertSee((string) $this->action->id);
        $this->assertTrue((bool) DB::table('action_scores')->where('token', 'secret-token')->value('rated'));
        $this->assertSame(1, DB::table('action_rating_scores')->count());

        $this->post('/ratings/action/store', $data + ['token' => 'secret-token'])->assertNotFound();
        $this->assertSame(1, DB::table('action_rating_scores')->count());
    }

    public function test_volunteer_ratings_use_the_user_of_the_token_without_a_login(): void
    {
        $userId = DB::table('users')->value('id');
        $ratingId = DB::table('action_ratings')->insertGetId([
            'action_id' => $this->action->id, 'user_id' => $userId, 'email' => 'coordinator@example.org',
            'token' => 'volunteers-token', 'rated' => false,
        ]);
        $volunteerId = DB::table('volunteers')->insertGetId(['name' => 'Anna', 'last_name' => 'K', 'fathers_name' => '', 'email' => 'anna@example.org']);

        $this->assertGuest();
        $this->post('/ratings/action/volunteers/store', [
            'token' => 'volunteers-token',
            'actionRatingId' => 999, // ignored: the token decides
            'volunteers' => [['id' => $volunteerId, 'comments' => 'Great', 'hours' => '3', 'minutes' => '30', 'ratings' => []]],
        ])->assertOk();

        $stored = DB::table('volunteer_action_ratings')->first();
        $this->assertSame($ratingId, (int) $stored->action_rating_id);
        $this->assertSame($userId, (int) $stored->user_id);
        $this->assertTrue((bool) DB::table('action_ratings')->where('id', $ratingId)->value('rated'));
    }
}
