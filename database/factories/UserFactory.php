<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('##########'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'customer',
            'status' => 'active',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'admin_role' => 'super_admin',
        ]);
    }

    public function restaurant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'restaurant',
            'restaurant_name' => fake()->company(),
        ]);
    }

    public function deliveryPartner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'delivery_partner',
            'availability_status' => 'offline',
        ]);
    }
}
