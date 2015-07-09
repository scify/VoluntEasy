$(document).ready(function () {

    var alarmActive = [];
    var notifications = [];

    /* every xx seconds check for notifications */
    setInterval(function () {

        //if the notification dropdown is not open,
        // and the user is not currently viewing any tasks, do the following
        if (!$("#notificationsDropdown").hasClass("open")) {
            /*
             * first hit the server and get the new notifications,
             * then send the 'alarmAndActive' notifications back to the server to change their status
             */
            $.when(hitServer())
                .then(function () {
                    console.log('alarmAndActive: ' + alarmActive.length);
                    stopBellNotification();
                });
        }
    }, 4000);


    /* hit the server to check for new notifications*/
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

                    // playSound();

                    var html = '';
                    //loop through the notifications and draw the
                    //notification list
                    $.each(data, function (i, notification) {

                        console.log(notification.id);

                        var notifClass = (notification.status == 'active' ? 'white' : 'grey');

                        //draw the <li> that holds all the notification info
                        html += '<li><a href="#" class="' + notifClass + '">';
                        html += '<div class="task-icon badge badge-info"><i class="icon-energy"></i></div>';
                        html += '<span class="badge badge-roundless badge-default pull-right">24min ago</span>';
                        html += '<p class="task-details">Notification id: ' + notification.id + '</p>';
                        html += '</a></li>';

                        //notifications that have a status of 'alarmAndActive'
                        //are kept to this array to be sent back to server
                        if (notification.status == 'alarmAndActive')
                            alarmActive.push(notification.id);

                        notifications.push(notification.id);
                    });

                    //append the <li>s to the <ul>
                    $("#notificationList").html(html);
                }
                else {
                    $("#notificationBadge").hide();
                    $("#notificationList").html('');

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
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        })
    }


    /* play a sound when there are new notifications */
    function playSound() {
        soundManager.setup({
            onready: function () {
                var mySound = soundManager.createSound({
                    id: 'aSound', // optional: provide your own unique id
                    url: '../assets/sounds/sounds-1054-suppressed.mp3'
                });
                mySound.play();
            }
        });
    }

    /*
     * when the bell is clicked and the user views the notification list,
     * send a request to the server with all the active/alarmAndActive notifications
     * to change their status to inactive.
     */
    $("#notificationBell").click(function () {
        if (!$(this).hasClass("open")) {
            $.each(notifications, function (i, id) {
                return $.ajax({
                    url: $("body").attr('data-url') + '/deactivateNotification/' + id,
                    method: "GET",
                    headers: {
                        'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });
            });
            $("#notificationBadge").hide();
            $(this).removeClass("open");
            $(this).addClass("open")
        }
    });
})
;
