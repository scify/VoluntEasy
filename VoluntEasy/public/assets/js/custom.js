$(document).ready(function () {

    //init tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /**
     * clear button clears all search fields
     */
    $("#clear").click(function(){
        $(".search").val('');
        $(".searchDropDown").val('0');
        $('.searchCheckbox').attr('checked', false);
    });

    //Submit the form through ajax.
    //The result data is the html of the table.
    $('#searchForm').on('submit', function (event) {
        event.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (data) {
                $("#table").html(data);
                console.log(data);
            }
        });
        return false; // prevent send form
    });

    /**
     * datepickers for the edit form
     */
    $('.startDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('.endDate').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('.endDate').datepicker('setStartDate', null);
    });

    //add restrictions: user should not be able to check
    // an end_date after start_date and vice-versa
    $('.endDate').datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('changeDate', function (selected) {
        var endDate = new Date(selected.date.valueOf());
        $('.startDate').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
        $('.startDate').datepicker('setEndDate', null);
    });


    /**
     * tooltips for the tree
     */
    $('.node.tooltips.notAssigned.disabled').tooltip({
        title: 'Δεν είστε υπεύθυνος της μονάδας και δεν μπορείτε να την επιλέξετε.',
        placement: 'bottom'
    });

    $('.node.tooltips.parent.disabled').tooltip({
        title: 'Δεν μπορείτε να προσθέσετε δράση σε μονάδα που έχει υπομονάδες.',
        placement: 'bottom'
    });

    $('.node.tooltips.leaf.hasActions.disabled').tooltip({
        title: 'Δεν μπορείτε να προσθέσετε υπομονάδα σε μονάδα που έχει δράσεις.',
        placement: 'bottom'
    });
});
