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

                            <p class="lead unit" data-id="aa">aa</p>

                        </div>

                        <div class="col-md-6">
                            <div id="appendTree">
                                <div id="unitsTree"></div>
                            </div>

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
    var html = '';
    $(".unit").click(function () {
        //add spinner while it loads
        $.ajax({
            url: '/main/units/tree/' + $(this).attr('data-id'),
            success: function (data) {
                console.log(html);
                html = '<ul id="tree" style="display:none">';
                html += '<li>' + data.id + ' ' + data.description + '<ul>';
                getLi(data.all_children);
                html += '</ul></li>';
                //console.log(html);
                $("#appendTree").empty();
                $("#appendTree").append(html);
                $("#tree").jOrgChart({
                    chartElement: '#unitsTree'
                });
            }
        });
    });

    function getLi(units) {
        for (var i in units) {
            if (units[i].hasOwnProperty('all_children') && units[i].all_children !== null && units[i].all_children.length > 0) {
                html += '<li>' + units[i].id + units[i].description + '<ul data-id="' + units[i].id + '">';
                getLi(units[i].all_children);
                html += '</ul></li>';
            } else if (units[i].all_children.length == 0) {
                html += '<li data-id="' + units[i].id + '">';
                html += units[i].id + units[i].description;
                html += '</li>';
            }
        }
    }
</script>
@stop