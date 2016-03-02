//save a subtask
$("#storeWorkDate").click(function (e) {
    e.preventDefault();
    if ($("#addWorkDateForm .work_date_comments").val() == null || $("#addWorkDateForm .work_date_comments").val() == '')
        $("#addWorkDateForm .comments_err").show();
    else {
        $("#addWorkDateForm .comments_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/store",
            method: 'GET',
            data: $("#addWorkDateForm").serialize(),
            success: function (result) {
                console.log(result);
                // location.reload();
            }
        });
    }
});


//populate the addWorkDate modal with data before displaying it
$(".addWorkDate").click(function (e) {

    $("#addWorkDate .subtaskId").val(subTask.id);

    //start adding the volunteers to the multiselect
    //first add the immediately available volunteers
    //aka those that belong to the unit of the action
    var optgroup = $('<optgroup>');
    optgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');
    $.each(subTask.unitVolunteers, function (i, volunteer) {
        var option = $("<option></option>");
        option.val(volunteer.id);
        option.text(volunteer.name + ' ' + volunteer.last_name);

        optgroup.append(option);
        $('#sub_volunteers').append(optgroup);
    });

    //add the cta_volunteers
    var notInPlatformOptgroup = $('<optgroup>');
    var notInUnitOptgroup = $('<optgroup>');
    notInPlatformOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');
    notInUnitOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');

    $.each(subTask.work_dates, function (i, date) {
        $.each(date.cta_volunteers, function (i, volunteer) {
            var option = $("<option></option>");
            option.val(volunteer.id);
            option.text(volunteer.name + ' ' + volunteer.last_name);

            var isInUnit = false;
            $.each(cta.volunteer.units, function (i, unit) {
                if (unitId == unit.id) {
                    isInUnit = true;
                    return false;
                }
            });

            if (volunteer.isVolunteer)
                notInPlatformOptgroup.append(option);
            if (volunteer.isInUnit)
                notInUnitOptgroup.append(option);

            $('#sub_volunteers').append(optgroup);
        });
    });


    refreshDateTime();

    //show modal
    $('#addWorkDate').modal('show');
});


//add another editable fields to fill in work date and hours
function addWorkDate(parentId) {

    if (validateWorkTable(parentId)) {
        $(".workError").show();
    }
    else {
        $(".workError").hide();
        $(parentId + " .workDates tr:last").clone().find("input").each(function () {
            $(this).val('');
        }).end().appendTo(parentId + " .workDates");

        refreshDateTime();
    }
}


//populate the editWorkDate modal before showing
function editWorkDate(id) {
    $.each(subTask.work_dates, function (i, date) {

        if (id == date.id) {
            console.log(date);
            $("#editWorkDate .workdateId").val(date.id);
            $("#editWorkDate .work_date_comments").val(date.comments);
            $("#editWorkDate .dateFrom").val(date.date_from);
            $("#editWorkDate .hourFrom").val(date.hour_from);
            $("#editWorkDate .hourTo").val(date.hour_to);

            refreshDateTime();
            $('#editWorkDate').modal('show');
            return false;
        }
    });
}