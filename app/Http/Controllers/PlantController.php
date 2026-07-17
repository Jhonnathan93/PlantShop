<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlantController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = $request->input('sort_by');

        $plants = Plant::query();

        switch ($sortBy) {
            case 'newest':
                $plants->orderByDesc('created_at');
                break;
            case 'oldest':
                $plants->orderBy('created_at');
                break;
            case 'price_high':
                $plants->orderByDesc('price');
                break;
            case 'price_low':
                $plants->orderBy('price');
                break;
            default:
                break;
        }

        $viewData = [];
        $viewData['title'] = __('controller.titles.plants');
        $viewData['subtitle'] = __('controller.list_of_plants');
        $viewData['plants'] = $plants->get();
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller._plants'), 'url' => route('plant.index')],
        ];

        return view('plant.index')->with('viewData', $viewData);
    }

    public function show(string $id, Request $request): View
    {
        $plant = Plant::with('category')->findOrFail($id);
        $viewData = [];
        $viewData['title'] = __('controller.colon_formatted.title', ['title' => $plant->getName()]);
        $viewData['subtitle'] = __('controller.colon_formatted.plant_information', ['plant' => $plant->getName()]);
        $viewData['plant'] = $plant;
        $viewData['reviews'] = Review::where('plant_id', $id)->get();
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller._plants'), 'url' => route('plant.index')],
            ['title' => $plant->getName(), 'url' => route('plant.show', ['id' => $plant->getId()])],
        ];

        $reviewsQuery = Review::where('plant_id', $id);

        $sortBy = $request->input('sort_by', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $reviewsQuery->orderBy('created_at');
                break;
            case 'lowest_rated':
                $reviewsQuery->orderBy('stars');
                break;
            case 'highest_rated':
                $reviewsQuery->orderByDesc('stars');
                break;
            default:
                $reviewsQuery->orderByDesc('created_at');
                break;
        }

        $viewData['reviews'] = $reviewsQuery->get();

        return view('plant.show')->with('viewData', $viewData);
    }

    public function search(Request $request): View
    {
        $search = $request->input('search');

        $plants = Plant::where('name', 'like', '%'.$search.'%')
            ->orWhere('description', 'like', '%'.$search.'%')
            ->get();

        $viewData = [];
        $viewData['title'] = __('controller.search_results');
        $viewData['subtitle'] = __('controller.search_results_for', ['search' => $search]);
        $viewData['plants'] = $plants;
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller._plants'), 'url' => route('plant.index')],
            ['title' => __('controller.search_results'), 'url' => route('plant.search')],
        ];

        return view('plant.index')->with('viewData', $viewData);
    }
}
