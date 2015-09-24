<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default smallHeading">
            <div class="panel-heading ">
                <h3 class="panel-title">Συμμετοχή σε δράσεις</h3>
            </div>
            <div class="panel-body">
                @if($actionsCount==0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default smallHeading">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Ο εθελοντής δεν έχει πάρει μέρος σε καμία δράση.</h4>
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
                        <th>Δράση</th>
                        <th>Υπέυθυνος</th>
                        <th>Διάρκεια</th>
                        <th>'Ωρες απασχόλησης</th>
                        <th>Αξιολόγηση</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timeline as $block)
                    @if($block->type=='action')
                    <tr>
                        <td class="col-md-2"><a href="{{ url('actions/one/'.$block->action->id) }}">{{ $block->action->description }}</a>
                        </td>
                        <td class="col-md-3">
                            {{ $block->action->name }} | <i class="fa fa-envelope"></i> {{ $block->action->email }}  | <i class="fa fa-phone"></i> {{ $block->action->phone_number }}
                        </td>
                        <td class="col-md-2">
                            {{ $block->action->start_date }} - {{ $block->action->end_date }}
                        </td>
                        <td class="col-md-2">

                        </td>
                        <td class="col-md-5">
                            @foreach($block->action->rating as $r)
                                <span id="attr1" class="attribute rating" data-score="{{ $r['rating'] }}"></span>
                                <small><span> {{ $r['attribute'] }} </span></small><br/>
                            @endforeach
                        </td>
                    </tr>
                    @endif
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
