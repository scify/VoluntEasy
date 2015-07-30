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

                <table id="volunteersTable" class="display table table-striped data-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Όνομα</th>
                        <th>Email</th>
                        <th>Διεύθυνση</th>
                        <th>Τηλέφωνο</th>
                        <th>Μονάδες</th>
                    </tr>
                    </thead>

                    <!--tfoot>
                    <tr>
                        <th>#</th>
                        <th>Όνομα</th>
                        <th>Email</th>
                        <th>Διεύθυνση</th>
                        <th>Τηλέφωνο</th>
                        <th>Μονάδες</th>
                    </tr>
                    </tfoot-->
                </table>


            </div>
        </div>
    </div>
</div>

@stop

@section('footerScripts')
<script>

    $('#volunteersTable').dataTable({
        "ajax": $("body").attr('data-url') + '/api/volunteers',
        "columns": [
            {data: "id"},
            {
                //concat first name with last name
                data: null, render: function (data, type, row) {
                return '<a href="' + $("body").attr('data-url') + '/volunteers/one/' + data.id + '">' + data.name + ' ' + data.last_name + '</a>';
            }
            },
            {
                //make email address clickable
                data: null, render: function (data, type, row) {
                return '<a href="mailto:' + data.email + '">' + data.email + '</a>';
            }
            },
            {
                //concat address with city, post box and country
                data: null, render: function (data, type, row) {
                var address = '';
                if (data.address != null && data.address != '')
                    address += data.address;
                if (data.city != null && data.city != '')
                    address += ', ' + data.city;
                if (data.post_box != null && data.post_box != '')
                    address += ', ' + data.post_box;
                if (data.country != null && data.country != '')
                    address += ', ' + data.country;

                return address;
            }
            },
            {
                //concat all phones
                data: null, render: function (data, type, row) {
                var phones = '';
                if (data.cell_tel != null && data.cell_tel != '')
                    phones += data.cell_tel;
                if (data.home_tel != null && data.home_tel != '')
                    phones += ', ' + data.home_tel;
                if (data.work_tel != null && data.work_tel != '')
                    phones += ', ' + data.work_tel;

                return phones;
            }
            },
            {
                // display unit statuses
                data: null, render: function (data, type, row) {
                var units = '';

                if (data.units != null && data.units.length >= 0) {

                    $.each(data.units, function (index, unit) {
                        if (unit.status == 'Pending')
                            units += '<div class="status pending" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι υπό ανάθεση στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Available')
                            units += '<div class="status available" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι διαθέσιμος στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                        else if (unit.status == 'Active')
                            units += '<div class="status active" data-toggle="tooltip" data-placement="bottom" title="Ο εθελοντής είναι ενεργός σε δράσεις στη μονάδα ' + unit.description + '">' + unit.description + '</div>';
                    });
                }
                return units;
            }
            }
        ]
    });

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
