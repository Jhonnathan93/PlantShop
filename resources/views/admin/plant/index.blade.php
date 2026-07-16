<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')
<div class='card m-5'>
    <div class='card-header d-flex justify-content-between align-items-center'>
        <h3 class='ms-3'>{{ __('admin.manage_plants') }}</h3>
        <form action="{{ route('admin.plant.create') }}" method="GET" class="d-flex mt-2">
            <button type="submit" class="btn btn-primary me-3">{{ __('admin.button_plant_create') }}</button>
        </form>
    </div>

    <div class='card-body'>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th scope='col'>{{ __('admin.table_header_plant_id') }}</th>
                    <th scope='col'>{{ __('admin.table_header_plant_name') }}</th>
                    <th scope='col'>{{ __('admin.table_header_plant_stock') }}</th>
                    <th scope='col'>{{ __('admin.table_header_plant_edit') }}</th>
                    <th scope='col'>{{ __('admin.table_header_plant_delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['plants'] as $plant)
                <tr>
                    <td><a href="{{ route('admin.plant.show', ['id' => $plant->getId()]) }}">{{ $plant->getId() }}</a>
                    </td>
                    <td>{{ $plant->getName() }}</td>
                    <td>{{ $plant->getStock() }}</td>
                    <td>
                        <a href="{{ route('admin.plant.edit', ['id' => $plant->getId()]) }}" class="btn btn-primary"><span class="material-symbols-outlined">{{ __('admin.button_plant_edit') }}</span></a>
                    </td>
                    <td><a href="{{ route('admin.plant.delete', ['id' => $plant->getId()]) }}"></a>
                        <form action="{{ route('admin.plant.delete', $plant->getId())}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><span class="material-symbols-outlined">{{ __('admin.button_plant_delete') }}</span></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
