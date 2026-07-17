@extends('layouts.app')
@section('title', $viewData['title'])
@section('hidePageHeader', true)
@section('content')
<section class="hero">
    <div class="container hero__inner">
        <div class="hero__content">
            <span class="eyebrow">{{ __('app.redesign.hero_eyebrow') }}</span>
            <h1 class="hero__title">{!! __('app.redesign.hero_title') !!}</h1>
            <p class="hero__copy">{{ __('app.redesign.hero_copy') }}</p>
            <div class="hero__actions">
                <a href="{{ route('plant.index') }}" class="btn btn-primary">{{ __('app.view_plants') }}</a>
                <a href="{{ route('guide.index') }}" class="btn btn-outline-primary">{{ __('app.view_guides') }}</a>
            </div>
        </div>
        <aside class="hero__note" aria-label="{{ __('app.redesign.featured_collection') }}">
            <span>{{ __('app.redesign.weekly_edit') }}</span>
            <strong>{!! __('app.redesign.indoor_sanctuary') !!}</strong>
            <p>{{ __('app.redesign.indoor_copy') }}</p>
        </aside>
    </div>
</section>

<section class="feature-section">
    <div class="container">
        <div class="section-heading">
            <div><span class="eyebrow">{{ __('app.redesign.explore_garden') }}</span><h2 class="section-title">{!! __('app.redesign.section_title') !!}</h2></div>
            <p class="section-copy">{{ __('app.redesign.section_copy') }}</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><x-catalog-card :title="__('app.plants')" :image="asset('img/cards/plant.jpg')" :href="route('plant.index')" :action="__('app.view_plants')"><p>{{ __('app.card_plants_available') }}</p></x-catalog-card></div>
            <div class="col-md-4"><x-catalog-card :title="__('app.categories')" :image="asset('img/cards/category.jpg')" :href="route('category.index')" :action="__('app.view_categories')"><p>{{ __('app.card_categories_available') }}</p></x-catalog-card></div>
            <div class="col-md-4"><x-catalog-card :title="__('app.guides')" :image="asset('img/cards/guide.png')" :href="route('guide.index')" :action="__('app.view_guides')"><p>{{ __('app.card_guides_available') }}</p></x-catalog-card></div>
        </div>
    </div>
</section>
@endsection
