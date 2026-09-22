<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\PipelineStage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pipeline_stage_id' => PipelineStage::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('0300-555-####'),
            'source' => fake()->randomElement(['Instagram', 'Walk-in', 'Referral']),
            'status' => 'open',
            'estimated_value' => fake()->numberBetween(5000, 25000),
            'notes' => fake()->sentence(),
            'next_follow_up_at' => fake()->dateTimeBetween('+1 day', '+2 weeks'),
        ];
    }
}
