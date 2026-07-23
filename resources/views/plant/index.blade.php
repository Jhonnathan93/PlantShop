@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container feature-section pt-5">
    @if ($errors->any())
        <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <div class="catalog-toolbar">
        <form id="plant-search-form" action="{{ route('plant.search') }}" method="GET">
            <label class="visually-hidden" for="plant-catalog-search">{{ __('app.search_plants') }}</label>
            <input id="plant-catalog-search" class="form-control" type="search" name="search" placeholder="{{ __('app.search_plants') }}">
        </form>
        <form action="{{ route('plant.index') }}" method="GET">
            <label class="visually-hidden" for="plant-sort">{{ __('app.select_plants_filter') }}</label>
            <select id="plant-sort" name="sort_by" class="form-select" onchange="this.form.submit()">
                <option value="" @selected(request('sort_by') === null || request('sort_by') === '')>{{ __('app.select_plants_filter') }}</option>
                <option value="newest" @selected(request('sort_by') === 'newest')>{{ __('app.select_newest_to_oldest') }}</option>
                <option value="oldest" @selected(request('sort_by') === 'oldest')>{{ __('app.select_oldest_to_newest') }}</option>
                <option value="price_high" @selected(request('sort_by') === 'price_high')>{{ __('app.select_price_higher_to_lower') }}</option>
                <option value="price_low" @selected(request('sort_by') === 'price_low')>{{ __('app.select_price_lower_to_higher') }}</option>
            </select>
        </form>
        <button form="plant-search-form" class="btn btn-primary" type="submit">{{ __('app.button_search') }}</button>
    </div>
    <div class="row g-4">
        @forelse ($viewData['plants'] as $plant)
            <div class="col-sm-6 col-lg-3">
                <x-catalog-card :title="$plant->getName()" :image="$plant->getImageUrl()" :href="route('plant.show', ['id' => $plant->getId()])" :action="__('app.more_details')" :eyebrow="'$'.$plant->getPrice()">
                    <p>{{ Str::limit($plant->getDescription(), 92) }}</p>
                </x-catalog-card>
            </div>
        @empty
            <div class="col-12"><div class="empty-state">{{ __('app.no_plants_for_this_category') }}</div></div>
        @endforelse
    </div>
</div>
@endsection
