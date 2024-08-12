<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Journey;
use Tests\TestCase;
use App\Models\User;
use MatanYadaev\EloquentSpatial\Objects\Point;

class JourneyTest extends TestCase
{
    use RefreshDatabase;


    public function test_api_response()
    {
        
    }
    public function test_create_journey()
    {

        $journey = Journey::create([
            'headline' => 'hello',
            'start_day' => '2024-07-18',
            'last_day' => '2024-07-18',
            'start_point' => new Point(51.5032973, -0.1217424),
            'end_point' => new Point(51.5032973, -0.1217424),
            'description' => 'hello',
            'journey_charg' => 100,
            'max_number' => 100,
        ]);

        $response = $this->get(uri: 'journey/'. $journey->id . '/edit' );

        // $this->assertDatabaseHas('journeys', [
        //     'headline' => 'hello',
        // ]);
        $response->assertStatus(status: 302);






    }

    public function test_create_button_from_dashboard_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(status: 200);
        $response->assertSee("create");
    }

}
