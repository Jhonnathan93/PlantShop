<nav class="navbar navbar-expand-lg site-nav" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand site-brand" href="{{ route('home.index') }}" aria-label="{{ __('app.redesign.home_label') }}">
            <span class="site-brand__mark">G</span>
            <span>Garden of Eden</span>
        </a>

        <button class="navbar-toggler site-nav__toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="{{ __('app.redesign.toggle_navigation') }}">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav mx-lg-auto site-nav__links">
                <li class="nav-item"><a class="nav-link" href="{{ route('plant.index') }}">{{ __('app.plants') }}</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('app.categories') }}</a>
                    <ul class="dropdown-menu site-nav__dropdown">
                        @foreach ($navigationCategories as $category)
                            <li><a class="dropdown-item" href="{{ route('category.show', ['id' => $category->getId()]) }}">{{ $category->getName() }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('guide.index') }}">{{ __('app.guides') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">{{ __('app.books') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('product.index') }}">{{ __('app.allied_store') }}</a></li>
            </ul>

            <div class="site-nav__actions">
                <form action="{{ route('plant.search') }}" method="GET" class="site-search" role="search">
                    <label class="visually-hidden" for="plant-search">{{ __('app.search') }}</label>
                    <input id="plant-search" name="search" type="search" placeholder="{{ __('app.search') }}">
                    <button type="submit" aria-label="{{ __('app.button_search') }}"><span class="material-symbols-outlined">search</span></button>
                </form>
                @guest
                    <a class="btn btn-ghost" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                    <a class="btn btn-light-pill" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                @else
                    <a class="icon-button" href="{{ route('cart.index') }}" aria-label="{{ __('app.plants_in_cart') }}"><span class="material-symbols-outlined">shopping_bag</span></a>
                    <div class="dropdown">
                        <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ __('app.redesign.account_menu') }}"><span class="material-symbols-outlined">account_circle</span></button>
                        <ul class="dropdown-menu dropdown-menu-end site-nav__dropdown">
                            <li><a class="dropdown-item" href="{{ route('user.index') }}">{{ __('auth.profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.index') }}">{{ __('admin.admin_panel') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form action="{{ route('logout') }}" method="POST">@csrf <button class="dropdown-item" type="submit">{{ __('auth.logout') }}</button></form></li>
                        </ul>
                    </div>
                @endguest
                <details class="language-selector">
                    <summary class="language-button" aria-label="{{ __('admin.language') }}">{{ strtoupper(app()->getLocale()) }}</summary>
                    <ul class="language-selector__menu site-nav__dropdown">
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}">{{ __('admin.english') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'es']) }}">{{ __('admin.spanish') }}</a></li>
                    </ul>
                </details>
            </div>
        </div>
    </div>
</nav>
