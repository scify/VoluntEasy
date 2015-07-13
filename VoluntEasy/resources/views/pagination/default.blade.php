@if($paginator->getLastPage() > 1)
<div class="pagination">
    {{ with(new App\Helpers\Paginator($paginator))->render() }}
</div>
@endif
