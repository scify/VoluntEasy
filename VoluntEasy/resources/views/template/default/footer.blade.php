<div class="page-footer">
    <p class="no-s">2015 &copy; SciFY.
        <small class="pull-right">
            @if (\Cookie::get('locale') === 'el')
            <a href="{{ url('/en') }}">{{trans('/default.english')}}</a>
            @else
            <a href="{{ url('/el') }}">{{trans('/default.greek')}}</a>
            @endif
        </small>
    </p>
</div>
