@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card-header">
    <h1 class="ms-5">{{ __('admin.hyphen_formatted_plant_title', ['title' => $viewData["plant"]->getName()]) }}</h1>
</div>
<div class="m-3 row">
    <div class="col-md-4">
        <img src="{{ $viewData['plant']->getImageUrl() }}" class="img-fluid rounded-start" alt="{{ $viewData['plant']->getName() }}">
    </div>
    <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title">{{ __('admin.colon_formatted_plant_name', ['name' => $viewData["plant"]->getName()]) }}</h5>
            <p class="card-text">{{ __('admin.colon_formatted_plant_id', ['id' => $viewData["plant"]->getId()]) }}</p>
            <p class="card-text">{{ __('admin.colon_formatted_plant_description', ['description' => $viewData["plant"]->getDescription()]) }}</p>
            <p class="card-text">{{ __('admin.colon_formatted_plant_price', ['price' => $viewData["plant"]->getPrice()]) }}</p>
            <p class="card-text">{{ __('admin.colon_formatted_plant_stock', ['stock' => $viewData["plant"]->getStock()]) }}</p>
            <p class="card-text">{{ __('admin.colon_formatted_plant_category', ['category' => $viewData["category_name"]]) }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('admin.plant.edit', ['id' => $viewData["plant"]->getId()]) }}" class="btn btn-primary me-2">{{ __('admin.button_plant_edit') }}</a>
        <form action="{{ route('admin.plant.delete', $viewData['plant']->getId())}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">{{ __('admin.button_plant_delete') }}</button>
        </form>
    </div>
</div>

@endsection
