@php
    $raw = $text ?? '';
    if ($raw !== '') {
        // Replace heading tags h2-h6 with non-semantic divs preserving attributes
        $raw = preg_replace('/<h([2-6])(\b[^>]*)>/i', '<div class="seo-h$1"$2>', $raw);
        $raw = preg_replace('/<\/h([2-6])>/i', '</div>', $raw);
    }
@endphp

{!! $raw !!}
