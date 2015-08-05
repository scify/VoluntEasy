@extends('default')

@section('title')
Προβολή Εθελοντών
@stop
@section('pageTitle')
Προβολή Εθελοντών
@stop

@section('bodyContent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <!--div class="panel-heading clearfix">
                <h4 class="panel-title">Αναζήτηση</h4>
            </div-->
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => ['VolunteerController@search'], 'id' => 'searchForm'])
                !!}
                @include('main.volunteers.partials._search')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Εθελοντές</h4>
            </div>
            <div class="panel-body">
                @include('main.volunteers.partials._table')
                <hr/>
                @include('main.volunteers.partials._legend')
            </div>
        </div>
    </div>
</div>

@stop

@section('footerScripts')
<script>
    //check this
    $(".delete").click(function () {
        if (confirm("Delete volunteer?") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/delete/' + $(this).attr('data-id'),
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function (data) {
                    window.location.href = $("body").attr('data-url') + "/volunteers";
                }
            });
        }
    });
</script>
@append
