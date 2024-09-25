<div class="flex flex-row justify-end">
    <a href="{{ $url() }}" {{ $attributes->merge(['class' => 'btn uppercase ']) }}>
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text }}
    </a>
</div>