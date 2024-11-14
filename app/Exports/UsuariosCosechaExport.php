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

        //TRAE ASIGNACIONES CON CIERRE Y CON LIBRAS DE PLANTA INGRESADA
        $asignaciones = $this->tarealotecosecha->asignaciones->filter(function($asignacion){
            if($asignacion->cierre && $asignacion->cierre->libras_total_planta){
                $asignacion->fechaCosecha = $asignacion->created_at->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY');
                $asignacion->plantas_cosechadas = $asignacion->cierre->plantas_cosechadas;
                $asignacion->fechaInicio = $asignacion->created_at->format('d-m-Y h:i:s A');
                $asignacion->fechaFinal = $asignacion->cierre->created_at->format('d-m-Y h:i:s A');
                $asignacion->TotalHoras = round(Carbon::parse($asignacion->fechaInicio)->diffInHours($asignacion->fechaFinal),3);
                $asignacion->totalCosechadoPlanta = $asignacion->cierre->libras_total_planta;
                $asignacion->totalCosechadoFinca = $asignacion->cierre->libras_total_finca;
    
                return $asignacion;
            }
        });

        $usuarios =  $this->tarealotecosecha->users()->orderBy('codigo','DESC')->get();


        $usuarios->map(function($asignacionUsuario) use ($asignaciones, $rows) {
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

                            $asignacionDiaria->porcentaje = ($asignacionUsuario->libras_asignacion/ $asignacionDiaria->totalCosechadoFinca);
                            $asignacionDiaria->cabezas_cosechadas = ($asignacionDiaria->porcentaje*$asignacionDiaria->totalCosechadoPlanta)/$pesoLbCabeza;
                            $asignacionDiaria->montoTotal = round(((($asignacionDiaria->totalCosechadoPlanta/ $rendimientoTeoricoPorPersona) * 8)*11.98),2);
                            $asignacionDiaria->peso_cabeza = $pesoLbCabeza;
                            return $asignacionDiaria;
                        }
                        
                    }
                }
                
            })->first();

            if($asignacion)
            {
                $horas_totales_cosecha = $asignacion->cabezas_cosechadas/120;

                $rows->push([
                    'CODIGO' => $asignacionUsuario->codigo,
                    'EMPLEADO' => $asignacionUsuario->nombre,
                    'PORCENTAJE' => $asignacion->porcentaje,
                    'FECHA' => $asignacion->created_at->format('d-m-y h:i:s'),
                    'LIBRAS REPORTADAS EN FINCA' => $asignacion->totalCosechadoFinca,
                    'LIBRAS ENTRADAS EN PLANTA' => $asignacion->totalCosechadoPlanta,
                    'TOTAL LIBRAS COSECHADAS' =>  $asignacionUsuario->libras_asignacion,
                    'PLANTAS COSECHADAS' =>  $asignacion->cierre->plantas_cosechadas,
                    'MONTO GANADO' => round($asignacion->porcentaje*$asignacion->montoTotal,4),
                    'HORAS EMPLEADAS' => $horas_totales_cosecha
                ]); 
            }
             
            
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
