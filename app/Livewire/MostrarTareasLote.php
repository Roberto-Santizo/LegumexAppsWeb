<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\TareasLote;
use App\Services\EmailService; 
use App\Models\EmpleadoIngresado;
use App\Models\RendimientoDiario;
use App\Services\MicrosoftTokenService;

class MostrarTareasLote extends Component
{
    protected $listeners = ['eliminarTarea','terminarTarea'];

    public $tareas;
    public $plansemanalfinca;
    public $atrasadas;
    public $lote;
    public $semanaActual;
    public $successTareaLoteId;
    public $successMessage;

    public function mount()
    {
        $this->actualizarTareas();
    }
    public function eliminarTarea(TareasLote $tarea)
    {
        $tarea->delete();
        $this->actualizarTareas();
    }

    public function actualizarTareas()
    {
        $this->tareas = $this->plansemanalfinca->tareasPorLote($this->lote->id)
            ->with([
                'asignacion' => function ($query) {
                    $query->latest();
                }
            ])
            ->get();

        foreach ($this->tareas as $tarea) {
            $tarea->cupos_utilizados = $tarea->users(Carbon::today())->count();
            $tarea->asignacion_diaria = $tarea->asignacion;

            $tarea->extendido = false;
            $tarea->ingresados = 0;

            if($tarea->movimientos->count() > 0){
                $tarea->semana_origen = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->semana;
                $tarea->finca = $tarea->movimientos()->orderBy('id','DESC')->first()->plan_origen->finca->finca;
            }
            if ($tarea->asignacion_diaria) {
                if (!$tarea->asignacion_diaria->created_at->isToday() && !$tarea->cierre) {
                    $tarea->extendido = true;

                    $usuariosIds = $tarea->users($tarea->asignacion_diaria->created_at)->pluck('usuario_id');

                    $empleadosIngresados = EmpleadoIngresado::whereIn('emp_id', $usuariosIds)
                        ->whereDate('punch_time', Carbon::today())
                        ->orderBy('punch_time', 'desc')
                        ->get();

                    $tarea->ingresados = $empleadosIngresados->count();
                }
            }
        }
    }

    public function terminarTarea(TareasLote $tarea)
    {
        $cierre = RendimientoDiario::create([
            'tarea_lote_id' => $tarea->id,
            'terminado' => 1
        ]);

        $tokenService = app(MicrosoftTokenService::class);
        $token = $tokenService->getValidAccessToken();

        $emailService = new EmailService($token);

        $recipientEmail = 'soportetecnico.tejar@legumex.net'; 
        $subject = 'Tarea Completada';
        $tareaContent = $tarea->tarea;
        $tareaId = $tarea->id;
        $loteContent = $tarea->lote;
        $planSemanalContent = $tarea->plansemanal;
        $bodyContent = <<<HTML
            <h1>¡La tarea: {$tareaContent->tarea} de lote {$loteContent->nombre} semana {$planSemanalContent->semana} fue completada con éxito!</h1>
            <table>
                <tr>
                    <td style="padding: 10px;">
                        <a href="https://legumexapps.domcloud.dev/agricola/tarea-lote/$tareaId" >
                            Click aquí para ver los detalles
                        </a>
                    </td>
                </tr>
            </table>
        HTML;

        $mensaje = $emailService->sendEmail($recipientEmail, $subject, $bodyContent);
        
        $this->successTareaLoteId = $tarea->id;
        $this->successMessage = 'La tarea fue terminada en fecha: ' . $cierre->created_at->format('d-m-Y h:i:s A') . ' ' .$mensaje;
        
    }

    public function render()
    {   
        $this->semanaActual = Carbon::now()->weekOfYear();
        return view('livewire.mostrar-tareas-lote');
    }

   
}
