<div class="flex flex-row justify-end my-5 md:m-0">
    <a href="{{ $url() }}" class="btn uppercase">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $text }}
    </a>
</div>