<?php

namespace Templates\Law\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Templates\Law\Models\Publication;

/**
 * @extends Factory<Publication>
 */
class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition(): array
    {
        return [
            'title' => rtrim(fake()->unique()->sentence(4), '.'),
            'type' => fake()->randomElement(array_keys(Publication::TYPES)),
            'summary' => fake()->sentence(16),
            'file' => 'documents/'.fake()->slug(3).'.pdf',
            'external_url' => null,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function external(): static
    {
        return $this->state(fn () => ['file' => null, 'external_url' => 'https://www.mevzuat.gov.tr/']);
    }
}
