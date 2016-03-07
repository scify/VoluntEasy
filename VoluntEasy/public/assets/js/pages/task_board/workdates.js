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
                reloadToTab('task_board');
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

        volunteers = [];
        $("#sub_volunteers_to option").each(function (name, val) {
            volunteers.push(val.value);
        });

        data = $("#editWorkDateForm").serializeArray();
        data.push({name: 'volunteers', value: volunteers});
        data.push({name: 'action_id', value: $("#actionId").attr('data-action-id')});

        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/update",
            method: 'GET',
            data: data,
            success: function (result) {
                reloadToTab('task_board');
                //console.log(result);
            }
        });
    }
});


//populate the addWorkDate modal with data before displaying it
$(".addWorkDate").click(function (e) {

    $("#addWorkDate .subtaskId").val(subTask.id);

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
                volunteer_id: volunteer_id,
                action_id: $("#actionId").attr('data-action-id')
            },
            success: function (result) {
                reloadToTab('task_board');
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

//delete a workdate
function deleteWorkDate(id) {

    if (confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε την ημέρα/ώρα;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/workdates/delete/" + id,
            data: {
                action_id: $("#actionId").attr('data-action-id')
            },
            success: function (result) {
                reloadToTab('task_board');
            }
        });
    }
}

//delete a workdate
function deleteCTAVolunteer(id) {

    if (confirm("Είστε σίγουροι ότι θέλετε να αφαιρέσετε τον ενδιαφερόμενο εθελοντή;") == true) {

        $.ajax({
            method: 'GET',
            url: $("body").attr('data-url') + "/ctaVolunteer/delete/" + id,
            success: function (result) {
                reloadToTab('task_board');
            }
        });
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
            $("#editWorkDate .volunteerSum").val(date.volunteer_sum);

            console.log(date.cta_volunteers);

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
                        if (cta.volunteer.length == 0) {
                            html += '<td>Βρέθηκε <a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.mightBe + '" target="_blank">εθελοντής</a> με το ίδιο email. Είναι ο ίδιος;</td>';
                            html += '<td><button type="button" class="btn btn-success right-margin" title="Έγκριση" onclick="assignToVolunteer(' + cta.mightBe + ',' + cta.id + ')"><i class="fa fa-check"></i></button>';
                            html += '<button type="button" class="btn btn-danger right-margin" title="Απόρριψη" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                        }
                        else {
                            //ctavolunteer is assigned to a profile
                            html += '<td>Έχει γίνει σύνδεση με υπάρχον <a href="' + $("body").attr("data-url") + '/volunteers/one/' + cta.volunteer[0].id + '" target="_blank">προφίλ</a>. Ο εθελοντής θα πρέπει να προστεθεί στη μονάδα της δράσης για να είναι διαθέσιμος.</td>';
                            html += '<td><button type="button"   class="btn btn-danger right-margin" title="Απόρριψη" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                        }
                    }
                    else {
                        html += '<td>Ο εθελοντής δεν βρέθηκε στην πλατφόρμα. Επικοινωνήστε μαζί του και δημιουργήστε το προφίλ του ή αναθέστε σε υπάρχον προφίλ.</td>';
                        html += '<td><button type="button" class="btn btn-success right-margin" title="Ανάθεση σε προφίλ"><i class="fa fa-leaf"></i></button>';
                        html += '<button type="button"  class="btn btn-danger right-margin" title="Απόρριψη" onclick="deleteCTAVolunteer(' + cta.id + ')"><i class="fa fa-trash"></i></button></td>';
                    }

                    html += '</tr>';
                });

                $('.ctaVolunteers table > tbody:last-child').html(html);
                $(".ctaVolunteers").show();
            }

            populateVolunteers(id);
            refreshDateTime();
            $('#editWorkDate').modal('show');
            return false;
        }
    });
}

//fill the volunteers multiselect
function populateVolunteers(workDateId) {
    $('#sub_volunteers').html('');

    //set the already assigned volunteers
    $('#sub_volunteers_to').html('');
    assigned = [];
    $.each(subTask.work_dates, function (i, date) {
        if (date.id == workDateId) {
            $.each(date.volunteers, function (i, volunteer) {
                var option = $("<option></option>");
                option.val(volunteer.id);
                option.text(volunteer.name + ' ' + volunteer.last_name);

                $('#sub_volunteers_to').append(option);

                assigned.push(volunteer.id);
            });
            return false;
        }
    });

    //add the immediately available volunteers
    //aka those that belong to the unit of the action
    $.each(subTask.unitVolunteers, function (i, volunteer) {
        if ($.inArray(volunteer.id, assigned) == -1) {
            var option = $("<option></option>");
            option.val(volunteer.id);
            option.text(volunteer.name + ' ' + volunteer.last_name);

            $('#sub_volunteers').append(option);
        }
    });
}
