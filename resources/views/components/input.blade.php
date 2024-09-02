<div class="my-5">
    @if ($label)
        <label for="{{ $name }}" class="label-input">{{ $label }} </label>
    @endif
    <input 
            type="{{ $type }}" 
            id="{{ $id }}"
            name="{{ $name }}" 
            class="border p-3 w-full rounded-lg @error('{{ $name }}') border-red-500 @enderror"
            placeholder="{{ $placeholder }}" 
            autocomplete="off" 
            value="{{ old($name, $value) }}"
            {{ $attributes  }}
        >

    @error($name)
        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
    @enderror
</div>