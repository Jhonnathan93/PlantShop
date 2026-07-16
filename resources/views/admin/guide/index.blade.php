<!-- Made by: Jhonnathan Stiven Ocampo Díaz -->

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')
<div class='card m-5'>
    <div class='card-header d-flex justify-content-between align-items-center'>
        <h3 class='ms-3'>Manage Guides</h3>
        <form action="{{ route('admin.guide.create') }}" method="GET" class="d-flex mt-2">
            <button type="submit" class="btn btn-primary me-3">Create Guide</button>
        </form>
    </div>

    <div class='card-body'>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th scope='col'>{{ __('admin.table_header_guide_id') }}</th>
                    <th scope='col'>{{ __('admin.table_header_guide_title') }}</th>
                    <th scope='col'>{{ __('admin.table_header_guide_edit') }}</th>
                    <th scope='col'>{{ __('admin.table_header_guide_delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['guides'] as $guide)
                <tr>
                    <td><a href="{{ route('admin.guide.show', ['id' => $guide->getId()]) }}">{{ $guide->getId() }}</a>
                    </td>
                    <td>{{ $guide->getTitle() }}</td>
                    <td>
                        <a href="{{ route('admin.guide.edit', ['id' => $guide->getId()]) }}" class="btn btn-primary"><span class="material-symbols-outlined">{{ __('admin.button_guide_edit') }}</span></a>
                    </td>
                    <td><a href="{{ route('admin.guide.delete', ['id' => $guide->getId()]) }}"></a>
                        <form action="{{ route('admin.guide.delete', $guide->getId())}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><span class="material-symbols-outlined">{{ __('admin.button_guide_delete') }}</span></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
