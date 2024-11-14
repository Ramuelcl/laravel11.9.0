<?php

namespace Database\Factories\Post;

use App\Models\backend\categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Import the Str class

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\post\post>
 */
class postFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $titulo = substr($this->faker->sentence, 0, 63);
        // $slug = Str::slug($titulo);
        $titulo = $this->faker->unique()->words($nb = 6, $asText = true);
        $titulo = ucwords($titulo); // Capitalize the first character of each word
        $slug = Str::slug($titulo);

        return [
            'titulo' => $titulo,
            'slug' => $slug,
            'contenido' => $this->faker->paragraph,
            // 'estado' => rand(0, 3),
            'estado' => $this->faker->randomElement(['sin_publicar', 'editando', 'en_revision', 'publicado']), // Use enum values

            'is_active' => $this->faker->boolean($chanceOfGettingTrue = 70),
            'image_path' => $this->faker->imageUrl(),
            'categoria_id' => categoria::inRandomOrder()->first()->id, // Assign a random category

        ];
    }
}
