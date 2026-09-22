<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'contact_id' => null,
            'activity_type' => 'note',
            'subject' => 'Lead note added',
            'description' => fake()->sentence(),
            'metadata' => ['source' => 'factory'],
            'occurred_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
        ];
    }
}
