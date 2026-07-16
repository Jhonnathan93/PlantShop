<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductService;
use App\Models\Category;
use Illuminate\View\View;

class ProductApiController extends Controller
{
    public function index(): View
    {
        $productApi = app(ProductService::class);
        $viewData['products'] = $productApi->getProducts();
        $viewData['categories'] = Category::all();
        $viewData['title'] = __('controller.titles.online_store');
        $viewData['subtitle'] = __('controller.titles.allied_store');
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller.products'), 'url' => route('product.index')],
        ];

        return view('product.index')->with('viewData', $viewData);
    }
}
