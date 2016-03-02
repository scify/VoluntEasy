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
                location.reload();
            }
        });
    }
});

//update a workdate
$("#updateWorkDate").click(function (e) {
    e.preventDefault();
    if ($("#editWorkDateForm .work_date_comments").val() == null || $("#editWorkDateForm .work_date_comments").val() == '')
        $("#editWorkDateForm .subtask-comments_err").show();
    else {
        $("#editWorkDateForm .subtask-comments_err").hide();

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/update",
            method: 'GET',
            data: $("#editWorkDateForm").serialize(),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//delete a workdate
$(".deleteWorkDate").click(function () {
    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε την ημέρα/ώρα;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/delete/" + $(this).attr('data-workdate-id'),
            success: function (result) {
                location.reload();
            }
        });
    }
});

//populate the addWorkDate modal with data before displaying it
$(".addWorkDate").click(function (e) {

    $("#addWorkDate .subtaskId").val(subTask.id);

    populateVolunteers(null, '#addWorkDate');
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
            $("#editWorkDate .workdateId").val(date.id);
            $("#editWorkDate .work_date_comments").val(date.comments);
            $("#editWorkDate .dateFrom").val(date.from_date);
            $("#editWorkDate .hourFrom").val(date.from_hour);
            $("#editWorkDate .hourTo").val(date.to_hour);

            populateVolunteers(id, '#editWorkDate');
            refreshDateTime();
            $('#editWorkDate').modal('show');
            return false;
        }
    });
}

//fill the volunteers multiselect
function populateVolunteers(workDateId, parent) {

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
        $(parent + ' .sub_volunteers').append(optgroup);
    });

    if (workDateId != null) {
        //add the cta_volunteers
        var notInPlatformOptgroup = $('<optgroup>');
        var notInUnitOptgroup = $('<optgroup>');
        notInPlatformOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');
        notInUnitOptgroup.attr('label', 'Εθελοντές που ανήκουν στη μονάδα');

        $.each(subTask.work_dates, function (i, date) {
            if (date.id == workDateId) {
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
            }
        });
    }
}