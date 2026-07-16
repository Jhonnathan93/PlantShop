<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('controller.titles.home');
        $viewData['subtitle'] = __('controller.titles.welcome');
        $viewData['categories'] = Category::all();
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
        ];

        return view('home.index')->with('viewData', $viewData);
    }

    public function locale(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, config('languages'), true), 404);
        session(['locale' => $locale]);

        return redirect()->back()->withCookie('locale', $locale);
    }
}
