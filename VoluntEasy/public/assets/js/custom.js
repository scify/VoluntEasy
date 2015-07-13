$(document).ready(function () {

    /**
     * clear button clears all search fields
     */
    $("#clear").click(function(){
        $(".search").val('');
        $(".searchDropDown").val('0');
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

});
