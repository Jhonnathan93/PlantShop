@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card-header">
    <h1 class="ms-5">{{ __('admin.hyphen_formatted_guide_title', ['title' => $viewData["guide"]->getTitle()]) }}</h1>
</div>
<div class="m-3 row">
    <div class="col-md-4">
        <img src="{{ $viewData['guide']->getImageUrl() }}" class="img-fluid rounded-start" alt="{{ $viewData['guide']->getTitle() }}">
    </div>
    <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title">{{ __('admin.colon_formatted_guide_title', ['title' => $viewData["guide"]->getTitle()]) }}</h5>
            <p class="card-t
            ext">{{ __('admin.colon_formatted_guide_id', ['id' => $viewData["guide"]->getId()]) }}</p>
            <p class="card-text">{{ __('admin.colon_formatted_guide_content', ['content' => $viewData["guide"]->getContent()]) }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <a href="{{ route('admin.guide.edit', ['id' => $viewData["guide"]->getId()]) }}" class="btn btn-primary me-2">{{ __('admin.button_guide_edit') }}</a>
        <form action="{{ route('admin.guide.delete', $viewData['guide']->getId())}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">{{ __('admin.button_guide_delete') }}</button>
        </form>
    </div>
</div>

@endsection
