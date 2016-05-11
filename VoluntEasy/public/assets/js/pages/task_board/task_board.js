/* General js scripts about the task board*/

//global variables to keep the task and subtask
var task;
var subTask;
var isPermitted = $("#actionId").attr('data-is-permitted');

//only let allowed user to move the cards
if (isPermitted == 'true') {

    $(".board-card").draggable({
        containment: ".task-" + $(this).attr('data-task') + " .board-column ",
        connectToSortable: ".board-column"
    });

    $(".board-column").sortable({
        placeholder: "ui-state-highlight",
        stop: function (event, ui) {
            var status;
            var taskId = $(ui.item).attr("data-task");
            var text = '';

            //when the task is moved, the status changes
            if ($(this).hasClass('todo'))
                status = 'To Do';
            else if ($(this).hasClass('doing'))
                status = 'Doing';
            else
                status = 'Done';

            //change the status while remaining at the same page
            $.ajax({
                url: $("body").attr('data-url') + "/actions/tasks/subtasks/updateStatus",
                method: 'GET',
                data: {
                    "action_id": $("#actionId").attr("data-action-id"),
                    "task_id": taskId,
                    "subTaskId": $(ui.item).attr("data-subtask"),
                    "status": status
                },
                success: function (result) {
                    if (result == 'todo')
                        text = 'TO DO';
                    else if (result == 'doing')
                        text = 'DOING';
                    else
                        text = 'DONE';

                    $("span.status.task-" + taskId).removeClass().addClass('status task-' + taskId + ' ' + result).text(text);
                }
            });
        }
    });
}
else {
    //display disabled cursor
    $(".board-card").css({
        cursor: 'not-allowed'
    });
}


//save the new open task id to the local storage
$(".task-title").click(function () {

    var taskId = null;
    if ($(this).attr('aria-expanded') == 'false')
        taskId = $(this).attr('data-task-id');

    localStorage.setItem("openTask", taskId);
});

//save the new open tab id to the local storage
$(".tab").click(function () {

    tabId = $(this).attr('data-tab');
    localStorage.setItem("openTab", tabId);
});


//retrieve the last opened task from the local storage and set as open
function setOpenTask() {
    var taskId = localStorage.getItem("openTask");
    if (taskId != null)
        $(".task-title.task-" + taskId).trigger("click");
}

//retrieve the last opened tab from the local storage and set as open
function setOpenTab() {
    var tabId = localStorage.getItem("openTab");

    if (tabId != null) {
        $(".tab ." + tabId).trigger("click");
    }
    else {
        $(".tab .details").trigger("click");
    }
}


function refreshDateTime() {

    $(".date").datepicker({
        language: 'el',
        format: 'dd/mm/yyyy',
        autoclose: true
    }).on('show', function (selected) {
        if (selected.date != null) {
            var date = new Date(selected.date.valueOf());
            $(this).attr('data-date', date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());
        }
    }).on('changeDate', function (selected) {
        var date = new Date(selected.date.valueOf());
        $(this).attr('data-date', date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());
    });

    $(".time").timepicker({
        lang: {
            'am': Lang.get('js-components.am'),
            'pm': Lang.get('js-components.pm')
        },
        'minTime': '07:00',
        'timeFormat': 'H:i'
    });
}
setOpenTab();
$(".multiple").select2();
refreshDateTime();

