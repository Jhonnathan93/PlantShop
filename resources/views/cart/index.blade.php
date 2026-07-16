@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
<div >
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<div class="card">
    <div class="card-header">{{ __('app.plants_in_cart') }}</div>
    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">{{ __('app.table_header_cart_id') }}</th>
                    <th scope="col">{{ __('app.table_header_cart_name') }}</th>
                    <th scope="col">{{ __('app.table_header_cart_price') }}</th>
                    <th scope="col">{{ __('app.table_header_cart_quantity') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["plants"] as $plant)
                <tr>
                    <td>{{ $plant->getId() }}</td>
                    <td>{{ $plant->getName() }}</td>
                    <td>${{ $plant->getPrice() }}</td>
                    <td>{{ session('plants')[$plant->getId()] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-outline-secondary mb-2"><b>{{ __('app.total_to_pay') }}</b>{{ $viewData["total"] }}</a>
                @if ($viewData['notEnoughBalance'])
                <a class="btn btn-outline-secondary mb-2"><b>{{ __('app.not_enough_balance') }}</b></a>
                <form action="{{ route('cart.delete') }}" method="POST"><!-- cart mutations must not use GET -->
                    @csrf
                    @method('DELETE')
                    <button class="btn bg-danger text-white mb-2">{{ __('app.remove_all_plants_from_cart') }}</button>
                </form>
                @else
                    @if (count($viewData["plants"]) > 0)
                    <form action="{{ route('cart.purchase') }}" method="POST" class="d-flex" role="search">
                        @csrf
                        <input name="address" class="form-control me-2" type="search" placeholder="{{ __('app.address') }}">
                        <button type="submit" class="btn bg-primary text-white">{{ __('app.purchase') }}</button>
                    </form>
                    <form action="{{ route('cart.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn bg-danger text-white mb-2">{{ __('app.remove_all_plants_from_cart') }}</button>
                    </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
