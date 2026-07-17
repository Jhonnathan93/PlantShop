<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('controller.titles.categories');
        $viewData['subtitle'] = __('controller.categories');
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller.categories'), 'url' => route('category.index')],
        ];

        return view('category.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $category = Category::findOrFail($id);
        $plants = Plant::where('category_id', '=', $id)->get();

        $viewData = [];
        $viewData['title'] = __('controller.colon_formatted_category', ['category' => $category->getName()]);
        $viewData['subtitle'] = __('controller.colon_formatted.category_plants', ['category' => $category->getName()]);
        $viewData['category'] = $category;
        $viewData['plants'] = $plants;
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller.categories'), 'url' => route('category.index')],
            ['title' => $category->getName(), 'url' => route('category.show', ['id' => $category->getId()])],
        ];

        return view('category.show')->with('viewData', $viewData);
    }
}
