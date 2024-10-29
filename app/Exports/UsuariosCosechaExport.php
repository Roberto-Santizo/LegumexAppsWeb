<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class UsuariosCosechaExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{
   
    protected $tarealotecosecha;

    // Constructor para recibir el ID
    public function __construct($tarealotecosecha)
    {
        $this->tarealotecosecha = $tarealotecosecha;
    }

    /**
        * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $rows = collect();
        Carbon::setLocale('es');

        $asignaciones = $this->tarealotecosecha->asignaciones->map(function($asignacion){
            $asignacion->fechaCosecha = $asignacion->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
            $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
            $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
            $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal),3);
            $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
            $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;

            return $asignacion;
        });


        $usuarios =  $this->tarealotecosecha->users()->orderBy('codigo','DESC')->get();
        $usuarios->map(function($asignacionUsuario) use ($asignaciones, $rows) {
            $asignacion = $asignaciones->filter(function($asignacionDiaria) use ($asignacionUsuario){
                if ($asignacionDiaria->created_at->toDateString() === $asignacionUsuario->created_at->toDateString()) {
                    $asignacionDiaria->totalPersonas = $asignacionDiaria->tareaLoteCosecha->users()->whereDate('created_at',$asignacionDiaria->created_at)->count();
                    $pesoLbCabeza = round(($asignacionDiaria->totalCosechadoPlanta / $asignacionDiaria->cierre->plantas_cosechadas),2);
                    $rendimientoTeoricoPorPersona =  round(($pesoLbCabeza * $asignacionDiaria->tareaLoteCosecha->tarea->cultivo->rendimiento),2);

                    $asignacionDiaria->montoTotal = round(((($asignacionDiaria->totalCosechadoPlanta/ $rendimientoTeoricoPorPersona) * 8)*11.98),2);
                    return $asignacionDiaria;
                }
            });

            $cosechadoPlanta = $asignacion->first()->totalCosechadoPlanta;
            $cosechadoFinca = $asignacion->first()->totalCosechadoFinca;
            $porcentaje = ($asignacionUsuario->libras_asignacion/ $cosechadoFinca );
            $libras_asignacion_planta = round((($porcentaje) * $cosechadoPlanta),4);
            $total_horas_empleadas = round($asignacion->first()->TotalHoras / $asignacion->first()->totalPersonas,3);

            $rows->push([
                'CODIGO' => $asignacionUsuario->codigo,
                'EMPLEADO' => $asignacionUsuario->nombre,
                'PORCENTAJE' => $porcentaje,
                'FECHA' => $asignacion->first()->created_at->format('d-m-y h:i:s'),
                'LIBRAS REPORTADAS EN FINCA' => $asignacion->first()->totalCosechadoFinca,
                'LIBRAS ENTRADAS EN PLANTA' => $asignacion->first()->totalCosechadoPlanta,
                'TOTAL LIBRAS COSECHADAS (FINCA)' =>  $asignacionUsuario->libras_asignacion,
                'PLANTAS COSECHADAS' =>  $asignacion->first()->cierre->plantas_cosechadas,
                'MONTO GANADO' => round($porcentaje*$asignacion->first()->montoTotal,4),
                'HORAS EMPLEADAS' => $total_horas_empleadas
            ]);
        });

        return $rows;
    }

    public function headings(): array
    { 
        return ['CODIGO', 'EMPLEADO','PORCENTAJE','FECHA','LIBRAS REPORTADAS EN FINCA','LIBRAS ENTRADAS EN PLANTA','TOTAL LIBRAS COSECHADAS (FINCA)','PLANTAS COSECHADAS','MONTO GANADO', 'HORAS EMPLEADAS'];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica estilos al rango A1:H1 (encabezados)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], 
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '5564eb'], 
            ],
        ]);

    }
    
    public function title(): string
    {
        return 'Usuarios Cosecha'; 
    }

      public function columnFormats(): array
    {
        return [
            'C' => '0.00%',
        ];
    }
}
