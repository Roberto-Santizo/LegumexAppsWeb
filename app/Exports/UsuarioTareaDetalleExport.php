<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\PlanSemanalFinca;
use App\Models\EmpleadoIngresado;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuarioTareaDetalleExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $plansemanal;

    public function __construct(PlanSemanalFinca $planSemanalFinca)
    {
        $this->plansemanal = $planSemanalFinca;
    }

    public function collection()
    {
        Carbon::setLocale('es');
        $rows = collect();

        $this->plansemanal->tareasTotales->each(function ($tarea) use ($rows) {
            if($tarea->cierresParciales->count() > 0){
                $this->distribucionPorEmpleado($tarea,$rows);
            }else{
                $this->procesarTarea($tarea, $rows);
            }
            
        });

        $this->plansemanal->tareasCosechaTotales->each(function ($tareaLoteCosecha) use ($rows) {
            $this->procesarTareaCosecha($tareaLoteCosecha, $rows);
        });

        return $rows;
    }

    protected function procesarTarea($tarea, &$rows)
    {
        if ($tarea->users->isEmpty()) return;

        $carbonFecha = $tarea->asignacion ? $tarea->asignacion->created_at->isoFormat('dddd') : '';

        foreach ($tarea->users as $asignacion) {
            $entrada = $this->obtenerPunch('asc', $asignacion);
            $salida = $this->obtenerPunch('desc', $asignacion);

            $rows->push([
                'CODIGO' => $asignacion->codigo,
                'EMPLEADO' => $asignacion->nombre,
                'LOTE' => $tarea->lote->nombre,
                'TAREA REALIZADA' => $tarea->tarea->tarea,
                'PLAN' => $tarea->extraordinaria ? 'EXTRAORDINARIA' : 'PLANIFICADA',
                'MONTO' => $asignacion->tarea_lote->cierre ? ($asignacion->tarea_lote->presupuesto / $tarea->users->count()) : '0',
                'HORAS TOTALES' => $asignacion->tarea_lote->cierre ? ($asignacion->tarea_lote->horas / $tarea->users->count()) : '0',
                'ENTRADA' => $entrada,
                'SALIDA' => $salida,
                'DIA' => $carbonFecha
            ]);
        }
    }

    protected function procesarTareaCosecha($tareaLoteCosecha, &$rows)
    {
        if ($tareaLoteCosecha->users->isEmpty()) return;

        $usuarios = $tareaLoteCosecha->users()->orderBy('codigo', 'DESC')->get();
        $asignaciones = $tareaLoteCosecha->asignaciones->map(function ($asignacion) {
            if($asignacion->cierre)
            {
                return $this->transformarAsignacion($asignacion);
            }
            
        });

        $usuarios->each(function ($asignacionUsuario) use ($asignaciones, $rows, $tareaLoteCosecha) {
            $this->procesarUsuarioCosecha($asignacionUsuario, $asignaciones, $tareaLoteCosecha, $rows);
        });
    }

    protected function transformarAsignacion($asignacion)
    {
        $asignacion->fechaCosecha = $asignacion->created_at->isoFormat('dddd D [de] MMMM [de] YYYY');
        $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
        $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
        $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal), 3);
        $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
        $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;
        $asignacion->created_at = $asignacion->created_at;
        return $asignacion;
    }

    protected function procesarUsuarioCosecha($asignacionUsuario, $asignaciones, $tareaLoteCosecha, &$rows)
    {
        $asignacion = $asignaciones->filter(function ($asignacionDiaria) use ($asignacionUsuario) {
            if($asignacionDiaria)
            {
                if($asignacionDiaria->created_at->toDateString() === $asignacionUsuario->created_at->toDateString())
                {
                    if($asignacionDiaria->totalCosechadoPlanta)
                    {
                        $asignacionDiaria->totalPersonas = $asignacionDiaria->tareaLoteCosecha->users()->whereDate('created_at',$asignacionDiaria->created_at)->count();
                        $pesoLbCabeza = round(($asignacionDiaria->totalCosechadoPlanta / $asignacionDiaria->cierre->plantas_cosechadas),2);
                        $rendimientoTeoricoPorPersona =  round(($pesoLbCabeza * $asignacionDiaria->tareaLoteCosecha->tarea->cultivo->rendimiento),2);
        
                        $asignacionDiaria->montoTotal = round(((($asignacionDiaria->totalCosechadoPlanta/ $rendimientoTeoricoPorPersona) * 8)*11.98),2);
                        $asignacionDiaria->peso_cabeza = $pesoLbCabeza;
                        return $asignacionDiaria;
                    }
                    
                }
            }
            
        })->first();
        
        if($asignacion)
        {
            $carbonFecha = $asignacion ? $asignacion->created_at->isoFormat('dddd') : '';
            $porcentaje = $asignacionUsuario->libras_asignacion / $asignacion->totalCosechadoFinca;
            $cabezas_cosechadas = ($porcentaje*$asignacion->totalCosechadoPlanta)/$asignacion->peso_cabeza;
            $horasTotales = $cabezas_cosechadas/120;

            $entrada = $this->obtenerPunch('asc', $asignacionUsuario);
            $salida = $this->obtenerPunch('desc', $asignacionUsuario);
    
            $rows->push([
                'CODIGO' => $asignacionUsuario->codigo,
                'EMPLEADO' => $asignacionUsuario->nombre,
                'LOTE' => $tareaLoteCosecha->lote->nombre,
                'TAREA REALIZADA' => $tareaLoteCosecha->tarea->tarea,
                'PLAN' => 'PLANIFICADA',
                'MONTO' => round($porcentaje * $asignacion->montoTotal, 4),
                'HORAS TOTALES' => $horasTotales,
                'ENTRADA' => $entrada,
                'SALIDA' => $salida,
                'DIA' => $carbonFecha
            ]);
        }
        
    }

    protected function obtenerPunch($orden, $asignacion)
    {
        $punch = EmpleadoIngresado::where('emp_id', $asignacion->usuario_id)
            ->whereDate('punch_time', $asignacion->created_at)
            ->orderBy('punch_time', $orden)
            ->first();

        return $punch ? $punch->punch_time->format('d-m-Y h:i:s') : 'no existe';
    }

    protected function obtenerPunchByKey($orden,$asignacion ,$key)
    {
        $punch = EmpleadoIngresado::where('emp_id', $asignacion->usuario_id)
            ->whereDate('punch_time', $key)
            ->orderBy('punch_time', $orden)
            ->first();

        return $punch ? $punch->punch_time->format('d-m-Y h:i:s') : 'no existe';
    }

    protected function distribucionPorEmpleado($tarea,$rows)
    {
        try {
            $fechas = [];

            $primerFecha = $tarea->asignacion->created_at;
            $ultimaFecha = $tarea->cierre->created_at;
            $fechas[] = $primerFecha;
            $fechas[] = $ultimaFecha;
    
            $fechasInicio = $tarea->cierresParciales()->pluck('fecha_inicio')->toArray();
            $fechasFinal = $tarea->cierresParciales()->pluck('fecha_final')->toArray();
    
            $fechasEntrada = collect(array_merge($fechasInicio, $fechasFinal))
                ->map(fn($fecha) => date('Y-m-d', strtotime($fecha)))
                ->unique()
                ->sort()
                ->values()
                ->toArray();
    
            $fechas = collect(array_merge($fechasInicio, $fechasFinal, $fechas))
                ->sort()
                ->values();
    
            $fechasAgrupadas = $fechas->groupBy(function ($fecha) {
                return $fecha->toDateString(); 
            });
    
            $fechasAgrupadas->map(function($fechas) {
                $horas_totales = $fechas[0]->diffInHours($fechas[1]);
                $fechas->horas_totales = $horas_totales;
            });
    
            $entradas_usuarios = [];
    
            $tarea->users->map(function ($user) use (&$entradas_usuarios,&$fechasEntrada) {
                foreach ($fechasEntrada as $fecha) {
                    $entrada = EmpleadoIngresado::whereDate('punch_time', $fecha)
                        ->where('emp_id', $user->usuario_id)
                        ->exists();
    
                    if ($entrada) {
                        if (!isset($entradas_usuarios[$fecha])) {
                            $entradas_usuarios[$fecha] = 0;
                        }
                        $entradas_usuarios[$fecha]++;
                    }
                }
            });
    
            $tarea->users->map(function ($user) use (&$fechasEntrada,&$fechasAgrupadas){
                $entradas = [];
                $horasTotales = 0;
                foreach ($fechasEntrada as $fecha) {
                    $entrada = EmpleadoIngresado::whereDate('punch_time', $fecha)->where('emp_id', $user->usuario_id)->get();
                    if (!$entrada->isEmpty()) {
                        $horas = $fechasAgrupadas[$fecha]->horas_totales;
                        $horasTotales += $fechasAgrupadas[$fecha]->horas_totales;
                        $entradas[$fecha] = ['estado' => true, 'horas' => $horas];
                    } else {
                        $entradas[$fecha] = ['estado' => false, 'horas' => 0];
                    }
                }
    
                $user->horasTotales = $horasTotales;
                $user->entradas = $entradas;
                return $user;
            });

            $tarea->users->map(function($user) use($tarea){
                $entradas = [];
                foreach ($user->entradas as $key => $entrada) {
                    $porcentaje_diario = $entrada['horas'] / $tarea->users->sum('horasTotales');
                    $entradas[$key]['estado'] = $entrada['estado'];
                    $entradas[$key]['horas']= $entrada['horas'];
                    $entradas[$key]['horas_diarias']=  $porcentaje_diario * $tarea->horas;;
                    $entradas[$key]['monto_diario'] = $porcentaje_diario * $tarea->presupuesto;
                }

                $user->entradas = $entradas;
                return $user;
            });


            foreach ($tarea->users as $asignacion) {
                foreach ($asignacion->entradas as $key => $entrada) {
                    $fechaCarbon = Carbon::parse($key);
                    $entradaBiometrico = $this->obtenerPunchByKey('asc', $asignacion,$key);
                    $salidaBiometrico = $this->obtenerPunchByKey('desc', $asignacion,$key);
    
                    if($entrada['estado']){
                        $rows->push([
                            'CODIGO' => $asignacion->codigo,
                            'EMPLEADO' => $asignacion->nombre,
                            'LOTE' => $tarea->lote->nombre,
                            'TAREA REALIZADA' => $tarea->tarea->tarea,
                            'PLAN' => 'PLANIFICADA',
                            'MONTO' => $entrada['monto_diario'],
                            'HORAS TOTALES' => $entrada['horas_diarias'],
                            'ENTRADA BIOMETRICO' => $entradaBiometrico,
                            'SALIDA BIOMETRICO' => $salidaBiometrico,
                            'DIA' => $fechaCarbon->isoFormat('dddd')
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        

    }

    public function headings(): array
    {
        return ['CODIGO', 'EMPLEADO', 'LOTE', 'TAREA REALIZADA', 'PLAN', 'MONTO GANADO', 'HORAS TOTALES', 'ENTRADA BIOMETRICO', 'SALIDA BIOMETRICO', 'DIA'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => '5564eb']],
        ]);
    }

    public function title(): string
    {
        return 'Detalle Tareas';
    }
}
