@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container detail-section">
    <article class="category-detail">
        <img src="{{ asset('img/categories/'.$viewData['category']->getImage()) }}" alt="{{ $viewData['category']->getName() }}">
        <div class="category-detail__content">
            <span class="eyebrow">{{ __('app.category') }}</span>
            <h2 class="detail-card__title">{{ $viewData['category']->getName() }}</h2>
            <dl class="detail-meta">
                <div class="detail-meta__item"><dt>{{ __('app.label_id') }}</dt><dd>{{ $viewData['category']->getId() }}</dd></div>
                <div class="detail-meta__item detail-meta__item--wide"><dt>{{ __('app.label_description') }}</dt><dd>{{ $viewData['category']->getDescription() }}</dd></div>
            </dl>
        </div>
    </article>

    <section class="category-plants">
        <h2 class="detail-section__title">{{ __('app.category_plants') }}</h2>
        <div class="row g-4">
            @forelse ($viewData['plants'] as $plant)
                <div class="col-sm-6 col-lg-3">
                    <x-catalog-card :title="$plant->getName()" :image="$plant->getImageUrl()" :href="route('plant.show', ['id' => $plant->getId()])" :action="__('app.more_details')" :eyebrow="'$'.$plant->getPrice()"><p>{{ Str::limit($plant->getDescription(), 92) }}</p></x-catalog-card>
                </div>
            @empty
                <div class="col-12"><div class="empty-state">{{ __('app.no_plants_for_this_category') }}</div></div>
            @endforelse
        </div>
    </section>
</div>
@endsection
