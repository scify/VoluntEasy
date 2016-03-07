/* General js scripts about the task board*/

//global variables to keep the task and subtask
var task;
var subTask;


$(".board-card").draggable({
    containment: ".task-" + $(this).attr('data-task') + " .board-column ",
    connectToSortable: ".board-column"
});

$(".board-column").sortable({
    placeholder: "ui-state-highlight",
    stop: function (event, ui) {
        var status;

        //when the task is moved, the status changes
        if ($(this).hasClass('todo'))
            status = 'To Do';
        else if ($(this).hasClass('doing'))
            status = 'Doing';
        else
            status = 'Done';

        taskId = $(ui.item).attr("data-task");

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

//save the new open task id to the local storage
$(".task-title").click(function () {

    var taskId = null;
    if ($(this).attr('aria-expanded')=='false')
        taskId = $(this).attr('data-task-id');

    localStorage.setItem("openTask", taskId);
});

function setOpenTask() {
    var taskId = localStorage.getItem("openTask");
    if (taskId != null)
        $(".task-title.task-" + taskId).trigger("click");
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
            'am': ' π.μ.',
            'pm': ' μ.μ.'
        },
        'minTime': '07:00',
        'timeFormat': 'H:i'
    });
}

//set the tab and reload
function reloadToTab(tab) {
    var url = window.location.href;
    url = url.substring(0, url.indexOf('&'));
    if (url.indexOf('?') > -1) {
        url += '&active=' + tab
    } else {
        url += '?active=' + tab
    }
    window.location.href = url;
}

function setToTab() {
    var tab = getParameterByName('active');
    if (tab == null)
        tab = 'details';

    $('.tab.' + tab).addClass('active');
    $('.tab-pane.' + tab).addClass('active');
}

setToTab();
$(".multiple").select2();
refreshDateTime();

