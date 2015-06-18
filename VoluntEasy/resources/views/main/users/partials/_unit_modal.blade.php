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
                        <div class="col-md-6">
                            @foreach ($units as $unit)
                            <p class="lead unit" data-id="{{ $unit->id }}">{{ $unit->description }}</p>
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <div id="appendTree"></div>
                            <div id="unitsTree"></div>
                            @foreach ($units as $unit)
                                <ul id="tree-{{ $unit->id }}" style="display:none;">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>

@section('footerScripts')
<script>
    $(".unit").click(function () {
        $(".jOrgChart").hide();

        if ( $(".jOrgChart.tree"+$(this).attr('data-id')).length>0 ) {
            $(".jOrgChart.tree"+$(this).attr('data-id')).show();
        }
        else {
            //$("#unitsTree").empty();
            $('#tree-' + $(this).attr('data-id')).jOrgChart({
                chartElement: '#unitsTree',
                chartClass: 'jOrgChart tree' + $(this).attr('data-id'),
                multiple: true
            });
        }
    });

</script>
@stop