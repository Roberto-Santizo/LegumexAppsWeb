<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdenTrabajo>
 */
class OrdenTrabajoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'planta_id' => $this->faker->randomElement([1,2]),
            'area_id' => $this->faker->randomElement([1,2]),
            'elemento_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'nombre_solicitante' => $this->faker->randomElement(['Roberto Santizo', 'Ricardo Perez', 'Juan Marquez']),
            'firma_solicitante' => $this->faker->uuid() . 'png',
            'equipo_problema' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'retiro_equipo' => $this->faker->randomElement([1,2]),
            'fecha_propuesta' => $this->faker->date('d-m-Y'),
            'problema_detectado' => $this->faker->sentence(15),
            'estado_id' => $this->faker->randomElement([1,2,3])
        ];
    }
}
