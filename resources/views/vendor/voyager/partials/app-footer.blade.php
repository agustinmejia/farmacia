<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="voyager-rum-1"></i> {{ __('voyager::theme.footer_copyright2') }}
        @else
            {!! __('voyager::theme.footer_copyright') !!} <a href="{{ env('APP_DEVELOPER_URL') }}" target="_blank">Server la estrella <i class="voyager-star"></i></a>
        @endif
        - {{ env('APP_VERSION', '0.1') }} {{ env('APP_DEBUG') == true ? ' - dev' : '' }}
    </div>
</footer>
