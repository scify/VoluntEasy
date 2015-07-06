<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myLargeModalLabel">Διαθέσιμες Οργανωτικές</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        {{$tree}}

                        <div class="col-md-6">
                            @foreach ($tree as $unit)
                            <p class="lead unit" data-id="{{ $unit->id }}">{{ $unit->description }}</p>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <div id="appendTree"></div>
                            <div id="unitsTreeEditable"></div>
                            @foreach ($tree as $unit)
                                <ul id="tree-{{ $unit->id }}" class="jOrgChartUl" style="display:none;">
                                    <li data-id="{{$unit->id}}"><span class="description">{{$unit->description}}</span>
                                        <ul>
                                            @include('main.units.partials._branch', ['unit' => $unit])
                                        </ul>

                                    </li>
                                </ul>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                <button type="button" class="btn btn-success" id="save">Αποθήκευση</button>
            </div>
        </div>
    </div>
</div>

@section('footerScripts')
<script>
    $(".unit").click(function () {
        $(".jOrgChart.editable").hide();

        if ( $(".jOrgChart.tree.editable"+$(this).attr('data-id')).length>0 ) {
            $(".jOrgChart.tree.editable"+$(this).attr('data-id')).show();
        }
        else {
            $('#tree-' + $(this).attr('data-id')).jOrgChart({
                chartElement: '#unitsTreeEditable',
                chartClass: 'jOrgChart editable tree' + $(this).attr('data-id'),
                multiple: true,
                ulId: '#tree-' + $(this).attr('data-id')
            });
        }
    });

    $("#save").click(function(){

        var activeLis = [];
        $("ul.jOrgChartUl").find("li.active").each(function(){
            activeLis.push($(this).attr('data-id'));
        });

        var userUnits = {
            id: $("#addUnits").attr('data-userid'),
            units: activeLis
        };

        $.ajax({
             url: $("body").attr('data-url') + '/users/units',
             method: 'POST',
             data: userUnits,
             headers: {
                 'X-CSRF-Token': $('input[name="_token"]').val()
             },
             success: function (data) {
                 window.location.href=$("body").attr('data-url') + "/users/one/"+data;
             }
             });
    })

</script>
@stop
