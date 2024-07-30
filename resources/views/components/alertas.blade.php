<div>
    @if(session('success'))
        <p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="bg-red-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('error') }}</p>
    @endif
</div>