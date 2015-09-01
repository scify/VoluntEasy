//define the global namespace.
window.scify = {}; //avoiding name space collusion

//
//(function($,undefined){
//
//
//    function saveVolunteer(volunteerId)
//    {
//        if (volunteerId == undefined)
//        {
//            //save new
//        }
//        else
//        {
//            //edit
//        }
//    }
//
//
//})(window.jquery);
//


$(document).ready(function () {

    //todo: move all view handler to methods that have a nice name

    var assignToolTips = function () {
            $('[data-toggle="tooltip"]').tooltip();
        },
        handleSearchFormFieldsReset = function () {
            $(".search").val('');
            $(".searchDropDown").val('0');
            $('.searchCheckbox').attr('checked', false);
        },
        submitSearchForm = function (event) {
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
                    table.fnClearTable();
                    if (data.data.length > 0)
                        table.fnAddData(data.data);
                }
            });
            return false; // prevent send form
        };


    assignToolTips();
    $("#clear").click(handleSearchFormFieldsReset); //event assignment or delegation
    $('#searchForm').on('submit', submitSearchForm);    //Submit the form through ajax.    //The result data should be reloaded to the datatable


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
    //an end_date after start_date and vice-versa
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


    //default user image
    $('img.userImage').one('error', function () {
        this.src = '/assets/images/default.png';
    });

    /**
     * tooltips for the tree
     */
    $('.node.tooltips.notAssigned.disabled').tooltip({
        title: 'Δεν είστε υπεύθυνος της μονάδας και δεν μπορείτε να την επιλέξετε.',
        placement: 'bottom'
    });

    $('.node.tooltips.parent.hasUnits.disabled').tooltip({
        title: 'Δεν μπορείτε να προσθέσετε δράση σε μονάδα που έχει υπομονάδες.',
        placement: 'bottom'
    });

    $('.node.tooltips.leaf.hasActions.disabled').tooltip({
        title: 'Δεν μπορείτε να προσθέσετε υπομονάδα σε μονάδα που έχει δράσεις.',
        placement: 'bottom'
    });


});
