<?php

namespace App\Services;

use Carbon\Carbon;

class SemanaService
{
    /**
     * Obtiene todas las fechas de una semana específica.
     *
     * @param int $semana
     * @param int|null $anio
     * @return array
     */
    public function obtenerFechasDeSemana(int $semana, int $anio = null): array
    {
        $anio = $anio ?? Carbon::now()->year;  // Usar el año actual si no se proporciona

        // Obtener la fecha de inicio de la semana (lunes)
        $fechaInicioSemana = Carbon::now()->setISODate($anio, $semana);

        // Iterar a través de los 7 días de la semana
        $fechas = [];
        for ($i = 0; $i < 7; $i++) {
            $fechas[] = $fechaInicioSemana->copy()->addDays($i)->format('d-m-Y');
        }

        return $fechas;
    }
}
