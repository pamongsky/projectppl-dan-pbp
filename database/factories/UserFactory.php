<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'id' => $this->generateId(), // Menghasilkan ID NIM/NIP
            'password' => static::$password ??= Hash::make('p123'), // Default password
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }

    /**
     * Generate a valid NIM/NIP for the `id` column.
     */
    private function generateId(): string
    {
        // Simulasi: 50% NIM (14 digit), 50% NIP (18 digit disingkat jadi 14)
        if (fake()->boolean(50)) {
            return fake()->numerify('240601########'); // NIM format
        }
        return fake()->numerify('19710######'); // NIP format
    }
}
