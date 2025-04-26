<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>UserFactory::new(),
            'total_price'=>$this->faker->numberBetween(1,100),
            'status'=>'pending',
            'phone'=>$this->faker->phoneNumber,
            'email'=>$this->faker->unique()->safeEmail,
            'address'=>$this->faker->address,
            'delivery_time'=>$this->faker->time(),
        ];
    }
}
