<?php

namespace Database\Factories\banca;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\banca\Movimiento;

class MovimientoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movimiento::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cuenta' => $this->faker->regexify('[A-Za-z0-9]{12}'),
            'tipo' => $this->faker->regexify('[A-Za-z0-9]{3}'),
            'dateMouvement' => $this->faker->date(),
            'libelle' => $this->faker->text,
            'montant' => $this->faker->randomFloat(2, 0, 999999.99),
            'francs' => $this->faker->randomFloat(2, 0, 999999.99),
            'cliente_id' => $this->faker->numberBetween(-100000, 100000),
            'releve' => $this->faker->numberBetween(-100000, 100000),
            'dateReleve' => $this->faker->date(),
            'estado' => $this->faker->numberBetween(-8, 8),
            'conciliada' => $this->faker->numberBetween(-8, 8),
        ];
    }
}
