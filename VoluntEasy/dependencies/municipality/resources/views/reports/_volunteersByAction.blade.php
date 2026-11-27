<table id="volunteersByActionTable" class="display table table-striped data-table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Δράση</th>
        <th>Διάρκεια</th>
        <th>Σύνολο εθελοντών/Απαιτούμενοι εθελοντές</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>Δράση</th>
        <th>Διάρκεια</th>
        <th>Σύνολο εθελοντών/Απαιτούμενοι εθελοντές</th>
    </tr>
    </tfoot>
</table>


@section('footerScripts')
<script>
    // the actions with their duration and their number of volunteers
    VE.ready(function () {
        window.table = VE.table('#volunteersByActionTable', {
            url: '/reports/volunteersByAction',
            columns: [
                {
                    // the action name with a link
                    data: null, render: function (data) {
                        return '<a href="' + VE.url('/actions/one/' + data.id) + '">' + VE.esc(data.description) + '</a>';
                    }
                },
                {
                    // the duration, grey when the action has expired
                    data: null, render: function (data) {
                        var dates = VE.esc(data.start_date + ' - ' + data.end_date);
                        return data.expired ? '<span class="inactive">' + dates + '</span>' : dates;
                    }
                },
                {
                    // the volunteers of the action / the volunteers it needs
                    data: null, render: function (data) {
                        var sum = data.volunteer_sum === null || data.volunteer_sum === '' || data.volunteer_sum === undefined ? '-' : data.volunteer_sum;
                        return VE.esc(data.volunteer_count + ' / ' + sum);
                    }
                }
            ],
            language: {
                lengthMenu: '_MENU_ γραμμές ανά σελίδα',
                zeroRecords: 'Δεν υπάρχουν δράσεις',
                info: 'Σελίδα _PAGE_ από _PAGES_',
                infoEmpty: 'Δεν υπάρχουν δράσεις',
                paginate: {first: 'Πρώτη', last: 'Τελευταία', next: 'Επόμενη', previous: 'Προηγούμενη'}
            },
            buttons: [{extend: 'copy', text: 'Αντιγραφή'}, {extend: 'print', text: 'Εκτύπωση'}, {extend: 'csv', text: 'CSV'}]
        });
    });
</script>
@append
