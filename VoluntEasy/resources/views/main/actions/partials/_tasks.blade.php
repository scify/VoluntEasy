<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">Tasks</h4>

                <div class="panel-control">
                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title=""
                       class="panel-collapse" data-original-title="Expand/Collapse"><i class="icon-arrow-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        @if(sizeof($action->tasks)>0)

                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>Όνομα</th>
                                    <th>Περιγραφή</th>
                                    <th>Εθελοντές</th>
                                    <th>Κατάσταση</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($action->tasks as $task)
                                    <tr>
                                        <td>{{$task->name}}</td>
                                        <td>{{$task->description}}</td>
                                        <td>-</td>
                                        <td>@if($task->isComplete)
                                                <div class="status completed">Ολοκληρωμένο</div>
                                            @else
                                                <div class="status incomplete">Μη ολοκληρωμένο</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('actions/tasks/'.$task->id.'/edit') }}"
                                               class="btn btn-success btn-sm removeFromUnit" data-volunteer-id="9"
                                               data-unit-id="1"><i class="fa fa-pencil fa-1x"></i></a>
                                            <button onclick="deleteTask({{ $task->id }})" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-remove fa-1x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Δεν υπάρχει κάνενα task για τη δράση.</p>
                        @endif
                        <a href="{{ url('actions/'.$action->id.'/tasks/create') }}" class="btn btn-success pull-right"
                           data-volunteer-id="9" data-unit-id="1">Προσθήκη task</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('footerScripts')
    <script>
        //delete task and redirect to action list
        function deleteTask(id) {
            if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το task;") == true) {
                $.ajax({
                    url: $("body").attr('data-url') + '/actions/tasks/delete/' + id,
                    method: 'GET',
                    headers: {
                        'X-CSRF-Token': $('#token').val()
                    },
                    success: function (data) {
                       location.reload();
                    }
                });
            }
        }
    </script>
@append