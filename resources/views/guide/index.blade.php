@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container feature-section pt-5">
    <div class="row g-4">
        @foreach ($viewData['guides'] as $guide)
            <div class="col-sm-6 col-lg-4">
                <x-catalog-card :title="$guide->getTitle()" :image="$guide->getImageUrl()" :href="route('guide.show', ['id' => $guide->getId()])" :action="__('app.more_details')" :eyebrow="__('app.guides')">
                    <p>{{ Str::limit($guide->getContent(), 115) }}</p>
                </x-catalog-card>
            </div>
        @endforeach
    </div>
</div>
@endsection
