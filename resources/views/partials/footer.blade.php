<footer class="site-footer">
    <div class="container site-footer__grid">
        <div>
            <a class="site-brand site-brand--footer" href="{{ route('home.index') }}"><span class="site-brand__mark">G</span><span>Garden of Eden</span></a>
            <p>{{ __('app.redesign.footer_copy') }}</p>
        </div>
        <div>
            <span class="eyebrow">{{ __('app.redesign.explore') }}</span>
            <a href="{{ route('plant.index') }}">{{ __('app.plants') }}</a>
            <a href="{{ route('category.index') }}">{{ __('app.categories') }}</a>
            <a href="{{ route('guide.index') }}">{{ __('app.guides') }}</a>
        </div>
        <div>
            <span class="eyebrow">{{ __('app.redesign.resources') }}</span>
            <a href="{{ route('books.index') }}">{{ __('app.books') }}</a>
            <a href="{{ route('product.index') }}">{{ __('app.allied_store') }}</a>
        </div>
    </div>
    <div class="container site-footer__bottom">© {{ now()->year }} Garden of Eden</div>
</footer>
