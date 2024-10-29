<div class="flex justify-end">
    <a href="{{ route($ruta, $parametros) }}"
        {{ $attributes->merge(['class' => 'cursor-pointer uppercase text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ']) }}>
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>
</div>