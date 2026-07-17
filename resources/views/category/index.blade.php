@extends('layouts.app')
@section('title', $viewData['subtitle'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container feature-section pt-5">
    <div class="row g-4">
        @foreach ($viewData['categories'] as $category)
            <div class="col-sm-6 col-lg-4">
                <x-catalog-card :title="$category->getName()" :image="asset('img/categories/'.$category->getImage())" :href="route('category.show', ['id' => $category->getId()])" :action="__('app.more_details')" :eyebrow="__('app.category')">
                    <p>{{ $category->getDescription() }}</p>
                </x-catalog-card>
            </div>
        @endforeach
    </div>
</div>
@endsection
