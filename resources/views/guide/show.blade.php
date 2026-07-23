@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container detail-section">
    <article class="detail-card guide-detail">
        <div class="detail-card__media">
            <img src="{{ $viewData['guide']->getImageUrl() }}" alt="{{ $viewData['guide']->getTitle() }}">
        </div>
        <div class="detail-card__content">
            <span class="eyebrow">{{ __('app.guides') }}</span>
            <h2 class="detail-card__title">{{ $viewData['guide']->getTitle() }}</h2>

            <dl class="detail-meta">
                <div class="detail-meta__item"><dt>{{ __('app.label_id') }}</dt><dd>{{ $viewData['guide']->getId() }}</dd></div>
                <div class="detail-meta__item detail-meta__item--wide">
                    <dt>{{ __('app.label_content') }}</dt>
                    <dd class="guide-detail__text">{!! nl2br(e($viewData['guide']->getContent())) !!}</dd>
                </div>
            </dl>
        </div>
    </article>
</div>
@endsection
