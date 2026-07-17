@extends('layouts.app')
@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])
@section('content')
<div class="container feature-section pt-5">
    <div class="books-intro"><span class="eyebrow">{{ __('app.redesign.reading_list') }}</span><p class="mb-0">{{ __('app.card_book_description') }}</p></div>
    <div class="row g-4">
        @forelse ($viewData['books'] as $book)
            <div class="col-sm-6 col-lg-3">
                <x-catalog-card :title="$book['title']" :eyebrow="__('app.books')">
                    <p><strong>{{ __('app.card_book_autor') }}</strong>{{ implode(', ', $book['author_name'] ?? ['N/A']) }}</p>
                    <p><strong>{{ __('app.card_book_year') }}</strong>{{ $book['publish_year'][0] ?? 'N/A' }}</p>
                    <p><strong>{{ __('app.card_book_language') }}</strong>{{ implode(', ', $book['language'] ?? ['N/A']) }}</p>
                </x-catalog-card>
            </div>
        @empty
            <div class="col-12"><div class="empty-state">{{ __('app.no_books_found') }}</div></div>
        @endforelse
    </div>
    <div class="book-pagination mt-5">
        {{ $viewData['books']->links('vendor.pagination.books') }}
    </div>
</div>
@endsection
