@extends('default')

@section('title')
Προβολή Συνεργασίας
@stop

@section('pageTitle')
Προβολή Συνεργασίας
@stop


@section('bodyContent')


<div class="panel panel-white tree">
    <div class="panel-heading clearfix">
        <h2 class="panel-title">Στοιχεία συνεργασίας</h2>

        <div class="panel-control">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-collapse"
               data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
        </div>
    </div>
    <div class="panel-body" style="display: block;">
        <div class="row">
            <div class="col-md-4">
                <h3>Συνεργασία {{ $collaboration->name }}</h3>

                <p><strong>Περιγραφή:</strong> {{ $collaboration->comments==null || $collaboration->comments=='' ? '-' :
                    $collaboration->comments }}</p>

                <p><strong>Διάρκεια:</strong> {{ $collaboration->start_date }} - {{ $collaboration->end_date }}</p>

                <p><strong>Διεύθυνση:</strong> {{ $collaboration->address==null || $collaboration->address=='' ? '-' :
                    $collaboration->address }}</p>

                <p><strong>Τηλέφωνο:</strong> {{ $collaboration->phone==null || $collaboration->phone=='' ? '-' :
                    $collaboration->phone }}</p>
            </div>

            <div class="col-md-4">
                <h3>Στοιχεία Υπευθύνου Συνεργασίας</h3>
                @if(sizeof($collaboration->executives)>0 && $collaboration->executives[0]->name!=null &&
                $collaboration->executives[0]->name!='')
                <ul class="list-unstyled">
                    <li class="user-list">
                        <p>{{$collaboration->executives[0]->name}}</p>

                        <p>
                            @if($collaboration->executives[0]->email!=null || $collaboration->executives[0]->email!='')
                            <i class="fa fa-envelope"></i> <a href="mail:to{{ $collaboration->executives[0]->email }}">{{
                                $collaboration->executives[0]->email }}</a>
                            @endif
                            @if($collaboration->executives[0]->phone!=null || $collaboration->executives[0]->phone!='')
                            <i class="fa fa-phone"></i> {{ $collaboration->executives[0]->phone }}
                            @endif
                            @if($collaboration->executives[0]->address!=null ||
                            $collaboration->executives[0]->address!='')
                            <i class="fa fa-map-marker"></i> {{ $collaboration->executives[0]->address }}</p>
                        @endif
                    </li>
                </ul>
                @else
                <p>Δεν έχει οριστεί υπεύθυνος δράσης</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>Αρχεία συνεργασίας</h3>
                @if(sizeof($collaboration->files)>0)
                <table class="table table-condensed table-bordered">
                    @foreach($collaboration->files as $file)
                    <tr>
                        <td><p><i class="fa fa-file-o"></i> <a
                                    href="{{ asset('assets/uploads/collaborations/'.$file->filename) }}"
                                    target="_blank">{{
                                    $file->filename }}</a></p>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-xs deleteFile" data-id="{{ $file->id }}"
                                    data-toggle="tooltip" data-placement="bottom" title="Διαγραφή"><i
                                    class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>


        <hr/>
        <div class="text-right">
            <a href="{{ url('collaborations/edit/'.$collaboration->id) }}" class="btn btn-success"><i
                    class="fa fa-edit"></i> Επεξεργασία</a>
            <button onclick="deleteCollaboration({{ $collaboration->id }})" class="btn btn-danger"><i
                    class="fa fa-trash"></i> Διαγραφή
            </button>
        </div>
    </div>
</div>
@stop


@section('footerScripts')
<script>
    //delete collaboration and redirect to collaborations list
    function deleteCollaboration(id) {
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε τη συνεργασία;") == true) {
            $.ajax({
                url: $("body").attr('data-url') + '/collaborations/delete/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    window.location = $("body").attr('data-url') + '/collaborations';
                }
            });
        }
    }

    //delete a file
    $(".deleteFile").click(function () {
        if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το αρχείο;")) {
            $.ajax({
                url: $("body").attr('data-url') + '/collaborations/deleteFile',
                method: 'POST',
                data: {
                    'id': $(this).attr('data-id')
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    document.location.reload();
                }
            });
        }
    });
</script>
@append
