@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container feature-section pt-5">
    <div class="row g-4">
        @forelse ($viewData['products'] as $product)
            <div class="col-sm-6 col-lg-4">
                <x-catalog-card :title="$product['name']" :eyebrow="$product['category']" :href="$product['link']" :action="__('app.product_link')">
                    <p>{{ $product['description'] }}</p>
                    <ul class="product-meta">
                        <li>{{ __('app.colon_formatted_product_price', ['price' => $product['price']]) }}</li>
                        <li>{{ __('app.colon_formatted_product_stock', ['stock' => $product['stock']]) }}</li>
                    </ul>
                </x-catalog-card>
            </div>
        @empty
            <div class="col-12"><div class="empty-state">{{ __('app.redesign.allied_store_unavailable') }}</div></div>
        @endforelse
    </div>
</div>
@endsection
