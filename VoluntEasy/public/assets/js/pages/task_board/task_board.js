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

        //change the status while remaining at the same page
        $.ajax({
            url: $("body").attr('data-url') + "/actions/tasks/subtasks/updateStatus",
            method: 'GET',
            data: {
                "action_id": $("#actionId").attr("data-action-id"),
                "task_id": $(ui.item).attr("data-task"),
                "subTaskId": $(ui.item).attr("data-subtask"),
                "status": status
            },
            success: function (result) {
            }
        });
    }
});

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


$(".multiple").select2();
refreshDateTime();

