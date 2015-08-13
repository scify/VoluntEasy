<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Κατάσταση Εθελοντή</h3>
            </div>
            <div class="panel-body">
                @if(sizeof($volunteer->units)==0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default smallHeading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Ο εθελοντής δεν ανήκει σε καμία οργανωτική μονάδα ή δράση.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Οργανωτική Μονάδα</th>
                        <th>Κατάσταση</th>
                        <th>Δράσεις</th>
                        <th class="text-center">
                            <small>Ανάθεση σε δράση<br/>ή υπομονάδα</small>
                        </th>
                        <th class="text-center">
                            <small>Αφαίρεση<br/>από μονάδα</small>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($volunteer->units as $unit)
                    <tr>
                        <td class="col-md-2"><a href="{{ url('units/one/'.$unit->id) }}">{{ $unit->description }}</a>
                        </td>
                        <td class="col-md-2">
                            @if($unit->status=='Pending')
                            <div class="status pending width-110">Υπό ένταξη</div>
                            @elseif($unit->status=='Available')
                            <div class="status available width-110">Διαθέσιμος</div>
                            @elseif($unit->status=='Active')
                            <div class="status active width-110">Ενεργός</div>
                            @else
                            @endif
                        </td>
                        <td class="col-md-4">
                            @if($unit->status=='Active')
                            @foreach($volunteer->actions as $action)
                            @if($action->unit_id==$unit->id)
                            <p>Δράση <strong><a href="{{ url('actions/one/'.$action->id) }}">{{
                                $action->description
                                }}</a></strong>
                                <small>({{ $action->start_date }} - {{ $action->end_date }})</small>
                                <br/>
                                <small><a href="#" class="removeFromAction" data-volunteer-id="{{ $volunteer->id }}"
                                          data-action-id="{{ $action->id }}"><i
                                        class="fa fa-remove fa-1x"></i> Αφαίρεση από τη δράση</a></small>
                            </p>
                            @endif
                            @endforeach
                            @elseif(sizeof($unit->actions)>0 && $unit->status=='Available')
                            <p style="color:#aaa;"><em>Ο εθελοντής δε συμμετέχει σε κάποια δράση της μονάδας</em></p>
                            @elseif(sizeof($unit->actions)==0)
                            <p style="color:#aaa;"><em>Η μονάδα δεν έχει δράσεις</em></p>
                            @endif
                        </td>
                        <td class="col-md-2">
                            <div class="text-center">
                                @if($volunteer->permitted && $unit->status=='Available' && sizeof($unit->actions)>0)
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#selectAction-unit{{$unit->id}}">
                                    <i class="fa fa-bookmark"></i>
                                </button>
                                @include('main.volunteers.partials.modals._select_action', ['divId' =>
                                'selectAction-unit'.$unit->id])
                                @endif

                                @if($volunteer->permitted && $unit->status=='Available' && sizeof($unit->children)>0)
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#selectUnit-unit{{$unit->id}}">
                                    <i class="fa fa-home"></i>
                                </button>
                                @include('main.volunteers.partials.modals._select_unit', ['units' =>
                                $unit->availableUnits, 'divId' => 'selectUnit-unit'.$unit->id, 'parentId' => $unit->id])
                                @endif
                            </div>
                        </td>
                        <td class="text-center col-md-2">
                            @if($volunteer->permitted)
                            <a href="#"
                               class="btn btn-danger btn-sm removeFromUnit" data-volunteer-id="{{ $volunteer->id }}"
                               data-unit-id="{{ $unit->id }}"><i
                                    class="fa fa-remove fa-1x"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@section('footerScripts')
<script>

    //display appropriate message before removing volunteer from action
    $(".removeFromAction").click(function (event) {
        event.preventDefault();
        if (confirm("Είτε σίγουροι ότι θέλετε να αφαιρέσετε τον εθελοντή από τη δράση;") == true) {
            volunteerId = $(this).attr('data-volunteer-id');
            actionId = $(this).attr('data-action-id');

            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/' + volunteerId + '/action/detach/' + actionId,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    location.reload();
                }
            });
        }
    });

    //display appropriate message before removing volunteer from unit
    $(".removeFromUnit").click(function (event) {
        event.preventDefault();
        if (confirm("Είτε σίγουροι ότι θέλετε να αφαιρέσετε τον εθελοντή από τη μονάδα;") == true) {
            volunteerId = $(this).attr('data-volunteer-id');
            unitId = $(this).attr('data-unit-id');

            $.ajax({
                url: $("body").attr('data-url') + '/volunteers/' + volunteerId + '/unit/detach/' + unitId,
                method: 'GET',
                headers: {
                    'X-CSRF-Token': $('#token').val()
                },
                success: function () {
                    location.reload();
                }
            });
        }
    });

</script>
@append
