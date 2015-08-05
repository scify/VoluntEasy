$(document).ready(function () {

    var alarmActive = [];
    var notifications = [];
    var ring;
    var pagetitle = $('title').text();
    var seconds = 4; //every xx seconds hit the server

    //set up the sound manager that will play  the ring sound
    soundManager.setup({
        onready: function () {
            ring = soundManager.createSound({
                id: 'aSound', // optional: provide your own unique id
                url: '../assets/sounds/sounds-1054-suppressed.mp3'
            });
        }
    });


    /* every xx seconds check for notifications */
    var timerLoop;
    var timer = function () {
        //if the notification dropdown is not open,
        // and the user is not currently viewing any tasks, do the following
        if (!$("#notificationsDropdown").hasClass("open")) {
            /*
             * first hit the server and get the new notifications,
             * then send the 'alarmAndActive' notifications back to the server to change their status
             */
            $.when(hitServer())
                .then(function () {
                    stopBellNotification();
                });
        }
        timerLoop = setTimeout(timer, seconds * 1000);
    };
    timer();

    /* hit the server to check for new notifications */
    function hitServer() {
        return $.ajax({
            url: $("body").attr('data-url') + '/checkForNotifications',
            dataType: "json",
            success: function (data) {
                alarmActive = [];
                notifications = [];

                $(".notificationSum").text(data.length);

                if (data.length > 0) {
                    //there are new notifications
                    $("#notificationBadge").show();

                    //add a (1) to the title!
                    $('title').text('(' + data.length + ') ' + pagetitle);

                    var html = '';
                    //loop through the notifications and draw the
                    //notification list
                    $.each(data, function (i, notification) {
                        //console.log(notification.id);

                        var notifClass = (notification.status == 'active' ? 'white' : 'grey');
                        var icon = '';

                        //depending on the notification type, change the icon
                        if (notification.type == "1") //user assigned to user
                            icon = '<div class="task-icon badge badge-info"><i class="icon-home"></i></div>';
                        else if(notification.type == "3") //action about to expire
                            icon = '<div class="task-icon badge badge-warning"><i class="icon-calendar"></i></div>';
                        else if(notification.type == "4") //action expired
                            icon = '<div class="task-icon badge badge-danger"><i class="icon-calendar"></i></div>';
                        else //default
                            icon = '<div class="task-icon badge badge-info"><i class="icon-info"></i></div>';


                        //draw the <li> that holds all the notification info
                        html += '<li class="' + notifClass + '"><a href="' + notification.url + '">';
                        html += icon;
                        html += '<p class="task-details">' + notification.msg + ' <small><em>(' + notification.when + ')</em></small></p>';
                        html += '</a></li>';

                        //notifications that have a status of 'alarmAndActive'
                        //are kept to this array to be sent back to server
                        if (notification.status == 'alarmAndActive')
                            alarmActive.push(notification.id);

                        notifications.push(notification.id);
                    });

                    //if there are alarmAndActive notifications, play a sound
                    if (alarmActive.length > 0)
                        ring.play();

                    //append the <li>s to the <ul>
                    $("#notificationList").html(html);
                }
                else {
                    $("#notificationBadge").hide();
                    $("#notificationList").html('');
                    $('title').text(pagetitle);
                }
            }
        });
    }

    /*
     * for each notification that has a status of 'alarmAndActive',
     * send the id to server to change the status to 'active'
     */
    function stopBellNotification() {
        $.each(alarmActive, function (i, id) {
            return $.ajax({
                url: $("body").attr('data-url') + '/stopBellNotification/' + id,
                method: "GET",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        })
    }

    /*
     * when the bell icon is clicked and the user views the notification list,
     * send a request to the server with all the active/alarmAndActive notifications
     * to change their status to inactive.
     */
    $("#notificationBell").click(function () {

        if (!$("#notificationsDropdown").hasClass("open")) {
            $.each(notifications, function (i, id) {
                return $.ajax({
                    url: $("body").attr('data-url') + '/deactivateNotification/' + id,
                    method: "GET",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });
            });
            $('title').text(pagetitle);
            $("#notificationBadge").hide();
            $(this).removeClass("open");
            $(this).addClass("open")
        }
    });
});
