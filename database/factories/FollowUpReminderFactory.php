<?php

namespace Database\Factories;

use App\Models\FollowUpReminder;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FollowUpReminder>
 */
class FollowUpReminderFactory extends Factory
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
            'title' => 'Confirm consultation appointment',
            'channel' => 'phone',
            'status' => 'pending',
            'due_at' => fake()->dateTimeBetween('+1 day', '+2 weeks'),
            'notes' => fake()->sentence(),
            'completed_at' => null,
        ];
    }
}
