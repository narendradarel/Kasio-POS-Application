<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
    * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'free',
            'product_limit' => 50,
            'user_limit' => 1,
            'customer_limit' => 20,
            'daily_pos_limit' => 20,
            'can_export_report' => false,
        ];
    }
}
