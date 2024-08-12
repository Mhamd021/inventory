<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'headline' => "'First Journey'",
            'start_day' => "2024-07-18",
            'last_day' => "2024-07-18",
            'start_point' => "ST_GeomFromText('Point(11 11)')",
            'end_point' => "ST_GeomFromText('Point(11 11)')",
            'description' => "'descsssss'",
            'journey_charg' => 100,
            'max_number' => 100,
        ];
    }
}
