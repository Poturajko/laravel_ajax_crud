<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = random_int(0,1);

        return [
            'name' => Str::title($this->faker->words(random_int(1,2),true)),
            'description' => $this->faker->sentence(),
            'is_published' => $rand,
            'published_at' => $rand ? $this->faker->dateTimeBetween('-5 years') : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
