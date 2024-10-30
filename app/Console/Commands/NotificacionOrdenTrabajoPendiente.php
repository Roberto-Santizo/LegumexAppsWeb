<?php

namespace App\Console\Commands;

use App\Services\NotificacionOrdenTrabajoPendienteService;
use Illuminate\Console\Command;

class NotificacionOrdenTrabajoPendiente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notificacion-orden-trabajo-pendiente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa si existe alguna orden pendiente sin mecanico asignado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reabastecimientoService = new NotificacionOrdenTrabajoPendienteService();
        $reabastecimientoService->checkSendNotification();

        $this->info('Proceso de reabastecimiento automático completado');
    }
}
