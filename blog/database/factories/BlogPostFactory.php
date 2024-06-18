<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $txt = $this->faker->realText(rand(1000, 4000));
        $date = $this->faker->dateTimeBetween('-3 months', '-2 months');

        return [

            'category_id'   => rand(1, 11),

            'user_id'       => (rand(1, 2) == 5) ? 1 : 2,

            'title'         => $title,

            'slug'          => Str::slug($title),

            'excerpt'       => $this->faker->text(rand(40, 100)),

            'content_raw'   => $txt,

            'content_html'  => $txt,

            'is_published'  => rand(1, 5) > 1,

            'published_at'  => rand(1, 5) > 1 ? $date : null,

            'created_at'     => $date,

            'updated_at'     => $date,

        ];
    }
}
