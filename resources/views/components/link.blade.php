<div class="flex flex-row justify-end">
    <a href="{{ $url() }}" class="btn uppercase">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text }}
    </a>
</div>