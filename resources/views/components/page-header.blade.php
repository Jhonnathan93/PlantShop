@props(['title', 'breadcrumbs' => []])

<header class="page-header">
    <div class="container">
        @if ($breadcrumbs)
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb page-header__breadcrumb mb-3">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1>{{ $title }}</h1>
    </div>
</header>
