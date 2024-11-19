<?php

namespace Database\Factories\banca;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\banca\Traspaso;

class TraspasoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Traspaso::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'libelle' => $this->faker->text,
            'montantEUROS' => $this->faker->regexify('[A-Za-z0-9]{12}'),
            'montantFRANCS' => $this->faker->regexify('[A-Za-z0-9]{12}'),
            'NomArchTras' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'IdArchMov' => $this->faker->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
