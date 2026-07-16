<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\BookService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class OpenLibraryController extends Controller
{
    public function index(Request $request): View
    {
        $currentPage = $request->input('page', 1);
        $perPage = 12;

        $bookService = app(BookService::class);
        $booksData = $bookService->fetchBooks($perPage, $currentPage);

        $viewData = [];
        $viewData['title'] = __('controller.colon_formatted.title', ['title' => 'Books']);
        $viewData['subtitle'] = __('controller.books');
        $viewData['categories'] = Category::all();
        $viewData['books'] = new LengthAwarePaginator(
            $booksData['books'],
            $booksData['total'],
            $booksData['perPage'],
            $booksData['currentPage'],
            ['path' => url()->current()]
        );
        $viewData['breadcrumbs'] = [
            ['title' => __('controller.home'), 'url' => route('home.index')],
            ['title' => __('controller.books'), 'url' => route('books.index')],
        ];

        return view('books.index')->with('viewData', $viewData);
    }
}
