<div class="page-footer">
    <p class="no-s">2015 &copy; SciFY.
        <small class="pull-right">
            @if (\Cookie::get('locale') === 'en')
            <a href="{{ url('/el') }}">{{trans('/default.greek')}}</a>
            @else
            <a href="{{ url('/en') }}">{{trans('/default.english')}}</a>
            @endif
        </small>
    </p>
</div>
