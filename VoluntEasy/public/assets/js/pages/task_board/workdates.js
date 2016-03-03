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

//assign a ctavolunteer to an existing volunteer
function assignToVolunteer(volunteer_id, cta_volunteer_id) {
    if (confirm("Είστε σίγουροι ότι θέλετε να γίνει η ανάθεση του εθελοντή σε υπάρχον προφίλ;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/ctaVolunteer/assignToVolunteer/",
            data: {
                cta_volunteer_id: cta_volunteer_id,
                volunteer_id: volunteer_id
            },
            success: function (result) {
                location.reload();
            }
        });
    }
}


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

            //check if ctaVolunteers table should be displayed,
            //aka the table that holds the volunteers that have claimed interest in the action
            if (date.cta_volunteers.length == 0) {
                $(".ctaVolunteers").hide();
            }
            else {
                var html = '';
                $.each(date.cta_volunteers, function (i, cta) {
                    html += '<tr><td>' + cta.first_name + ' ' + cta.last_name + '</td>';
                    html += '<td><a href="mailto:' + cta.email + '">' + cta.email + '</a>, ' + cta.phone_number;

                    if (cta.comments != null && cta.comments != '')
                        html += '<br/>Σχόλια εθελοντή: ' + cta.comments + '</td>';
                    else
                        html += '</td>';

                    //volunteer was found in platform
                    if (cta.isVolunteer == 1) {
                        //ctavolunteer is not assigned to any actual volunteer profile
                        if (cta.volunteer.length==0) {
                            html += '<td>Βρέθηκε <a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.mightBe + '" target="_blank">εθελοντής</a> με το ίδιο email. Είναι ο ίδιος;</td>';
                            html += '<td><button type="button" class="btn btn-success right-margin" title="Έγκριση" onclick="assignToVolunteer(' + cta.mightBe + ',' + cta.id + ')"><i class="fa fa-check"></i></button>';
                            html += '<button type="button"   class="btn btn-danger right-margin" title="Απόρριψη"><i class="fa fa-trash"></i></button></td>';
                        }
                        else {
                            //ctavolunteer is assigned to a profile
                            html += '<td>Έχει γίνει σύνδεση με υπάρχον <a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.volunteer[0].id + '" target="_blank">προφίλ</a>. Ο εθελοντής θα πρέπει να προστεθεί στη μονάδα της δράσης για να είναι διαθέσιμος.</td>';
                            html += '<td><button type="button"   class="btn btn-danger right-margin" title="Απόρριψη"><i class="fa fa-trash"></i></button></td>';
                        }
                    }
                    else {
                        html += '<td>Ο εθελοντής δεν βρέθηκε στην πλατφόρμα. Επικοινωνήστε μαζί του και δημιουργήστε το προφίλ το ή αναθέστε σε υπάρχον προφίλ.</td>';
                        html += '<td><button type="button" class="btn btn-success right-margin" title="Ανάθεση σε προφίλ"><i class="fa fa-leaf"></i></button>';
                        html += '<button type="button"  class="btn btn-danger right-margin" title="Απόρριψη"><i class="fa fa-trash"></i></button></td>';
                    }

                    html += '</tr>';
                });

                $('.ctaVolunteers > tbody:last-child').html(html);
                $(".ctaVolunteers").show();
            }

            populateVolunteers(id, '#editWorkDate');
            refreshDateTime();
            $('#editWorkDate').modal('show');
            return false;
        }
    });
}

//fill the volunteers multiselect
function populateVolunteers(workDateId, parent) {

    $(parent + ' .sub_volunteers').html('');

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

    /*
     if (workDateId != null) {
     //add the cta_volunteers
     var notInPlatformOptgroup = $('<optgroup>');
     var notInUnitOptgroup = $('<optgroup>');
     notInPlatformOptgroup.attr('label', 'Εθελοντές που δεν υπάρχουν στην πλατφόρμα');
     notInUnitOptgroup.attr('label', 'Εθελοντές που δεν ανήκουν στη μονάδα');

     $.each(subTask.work_dates, function (i, date) {
     if (date.id == workDateId) {
     $.each(date.cta_volunteers, function (i, volunteer) {
     var option = $("<option></option>");
     option.val(volunteer.id);
     option.text(volunteer.first_name + ' ' + volunteer.last_name);

     if (volunteer.isVolunteer==1) {
     var isInUnit = false;
     $.each(volunteer.volunteer.units, function (i, unit) {
     if (unitId == unit.id) {
     isInUnit = true;
     return false;
     }
     });
     }

     if (volunteer.isVolunteer==1)
     notInPlatformOptgroup.append(option);
     if (volunteer.isInUnit)
     notInUnitOptgroup.append(option);
     });
     }
     });

     $(parent + ' .sub_volunteers').append(notInPlatformOptgroup);
     $(parent + ' .sub_volunteers').append(notInUnitOptgroup);
     }
     */
}
