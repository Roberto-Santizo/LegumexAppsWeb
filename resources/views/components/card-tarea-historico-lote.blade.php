<div class="grid grid-cols-2 gap-1">
    <div class="bg-green-moss text-white p-2">
        <h2 class="text-center font-bold text-2xl">Información de tarea: </h2>
        <p>{{ $tarea->tarea->tarea }}</p>
        <p>{{ $tarea->cierre ? 'CERRADA' : 'SIN CIERRE' }}</p>
        <p>{{ $tarea->cierre ? $tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at) : 'SIN CIERRE' }}</p>
    </div>

    <div class="bg-purple-400 text-white">
        <h2 class="text-center font-bold text-2xl">Información de Insumos</h2>
    </div>
</div>