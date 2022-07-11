<?php

namespace Database\Factories\User;

use App\Models\Stock\Basket;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /** @var string  */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            User::FIRST_NAME => $this->faker->firstName(),
            User::LAST_NAME => $this->faker->lastName(),
            User::GENDER => $this->faker->randomElement(User::$genders),
            User::USERNAME => $this->faker->unique()->userName(),
            User::EMAIL => $this->faker->unique()->safeEmail(),
            User::PASSWORD => bcrypt('Dc123456'),
            User::IS_ACTIVE => $this->faker->boolean,
            User::MOBILE => $this->faker->numberBetween(10000000000,99999999999),
            User::INTERNATIONAL_NUMBER => $this->faker->numberBetween(1000000000, 9999999999),
        ];
    }

    /**
     * @param int $analystId AnalystId.
     *
     * @return $this
     */
    public function hasBaskets(int $analystId): self
    {
        return $this->afterCreating(
            fn (User $user) => Basket::factory()
                ->count(rand(1, 3))
                ->for($user)
                ->hasBasketItems(rand(2, 10))
                ->create([Basket::ANALYST_ID => $analystId])
        );
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
