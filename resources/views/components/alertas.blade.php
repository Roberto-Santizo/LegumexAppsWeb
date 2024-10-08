<div>
    @if(session('success'))
        <div class="border border-green-500 bg-green-100 text-green-700 font-bold uppercase p-2 mt-5 mb-5  text-sm flex flex-row gap-2 items-center">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @elseif (session('error'))
    <div class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>{{ session('error') }}</p>
    </div>
    @endif
</div>