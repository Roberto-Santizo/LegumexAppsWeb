<div class="mb-5">
    <label for="{{ $id }}" class="label-input">{{ $label }}: </label>
    <select name="{{ $name }}" id="{{ $id }}" class="w-full p-4 rounded bg-gray-50 {{ ( $buscador ) ? 'select' : '' }}">
        <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
        @foreach ($options as $value => $display)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
    @error($name)
    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
    @enderror
</div>
