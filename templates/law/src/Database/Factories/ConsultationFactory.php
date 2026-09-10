<?php

namespace Templates\Law\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Templates\Law\Models\Consultation;

/**
 * @extends Factory<Consultation>
 */
class ConsultationFactory extends Factory
{
    protected $model = Consultation::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'subject' => rtrim(fake()->sentence(5), '.'),
            'message' => fake()->paragraph(),
            'preferred_contact' => fake()->randomElement(array_keys(Consultation::CONTACT_METHODS)),
            'preferred_date' => fake()->boolean(60) ? fake()->dateTimeBetween('+1 day', '+3 weeks') : null,
            'status' => 'new',
            'ip' => fake()->ipv4(),
        ];
    }

    public function status(string $status): static
    {
        return $this->state(fn () => ['status' => $status]);
    }
}
