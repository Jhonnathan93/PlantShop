@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container detail-section">
    <article class="detail-card">
        <div class="detail-card__media">
            <img src="{{ asset('storage/plants/'.$viewData['plant']->getImage()) }}" alt="{{ $viewData['plant']->getName() }}">
        </div>
        <div class="detail-card__content">
            <span class="eyebrow">{{ __('app.category') }} · {{ $viewData['plant']->getCategory()->getName() }}</span>
            <h2 class="detail-card__title">{{ $viewData['plant']->getName() }}</h2>

            <dl class="detail-meta">
                <div class="detail-meta__item"><dt>{{ __('app.label_id') }}</dt><dd>{{ $viewData['plant']->getId() }}</dd></div>
                <div class="detail-meta__item"><dt>{{ __('app.label_price') }}</dt><dd>${{ $viewData['plant']->getPrice() }}</dd></div>
                <div class="detail-meta__item detail-meta__item--wide"><dt>{{ __('app.label_description') }}</dt><dd>{{ $viewData['plant']->getDescription() }}</dd></div>
                <div class="detail-meta__item"><dt>{{ __('app.label_stock') }}</dt><dd>{{ $viewData['plant']->getStock() }}</dd></div>
            </dl>

            @guest
                <aside class="detail-notice">
                    <p>{{ __('app.comments_login') }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('auth.login') }}</a>
                </aside>
            @else
                <form method="POST" action="{{ route('cart.add', ['id' => $viewData['plant']->getId()]) }}" class="detail-purchase">
                    @csrf
                    <label for="quantity">{{ __('app.table_header_product_quantity') }}</label>
                    <input id="quantity" type="number" min="1" max="10" class="form-control quantity-input" name="quantity" value="1">
                    <button class="btn btn-primary" type="submit">{{ __('app.add_to_cart') }}</button>
                </form>
            @endguest
        </div>
    </article>

    @auth
        <section class="detail-comments">
            <h2 class="detail-section__title">{{ __('app.comments') }}</h2>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
            @endif
            @if ($errors->any())
                <ul id="errors" class="alert alert-danger list-unstyled">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            @endif
            <div class="review-list">
                @forelse ($viewData['reviews'] as $review)
                    <article class="review-card"><p>{{ $review->getContent() }}</p><span>{{ __('app.stars', ['stars' => $review->getStars()]) }}</span></article>
                @empty
                    <p class="detail-empty">{{ __('app.no_reviews') }}</p>
                @endforelse
            </div>
            <form method="POST" action="{{ route('review.save') }}" class="review-form">
                @csrf
                <input type="hidden" name="plant_id" value="{{ $viewData['plant']->getId() }}">
                <label for="content">{{ __('app.add_comment') }}</label>
                <textarea id="content" class="form-control" name="content" rows="3">{{ old('content') }}</textarea>
                <label for="stars">{{ __('app.rating') }}</label>
                <input id="stars" type="number" min="1" max="5" class="form-control" name="stars" value="{{ old('stars') }}">
                <button type="submit" class="btn btn-primary">{{ __('app.button_comment_send') }}</button>
            </form>
        </section>
    @endauth
</div>
@endsection
