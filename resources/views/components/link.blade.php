<div class="flex flex-row justify-end">
    <a href="{{ $url() }}" class="btn uppercase mt-5">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text }}
    </a>
</div>