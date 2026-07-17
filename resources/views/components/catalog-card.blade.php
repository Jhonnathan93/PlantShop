@props(['title', 'image' => null, 'href' => null, 'eyebrow' => null, 'action' => null])

<article {{ $attributes->merge(['class' => 'catalog-card h-100']) }}>
    @if ($image)
        <div class="catalog-card__media">
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
        </div>
    @endif
    <div class="catalog-card__body">
        @if ($eyebrow)
            <span class="eyebrow">{{ $eyebrow }}</span>
        @endif
        <h3 class="catalog-card__title">{{ $title }}</h3>
        <div class="catalog-card__content">{{ $slot }}</div>
        @if ($href && $action)
            <a href="{{ $href }}" class="text-link">
                {{ $action }} <span aria-hidden="true">↗</span>
            </a>
        @endif
    </div>
</article>
