/*
 * The notification bell of the top bar (plain JavaScript).
 * Every few seconds it gets the notifications of the user, draws the list,
 * rings for the new ones ('alarmAndActive') and tells the server to stop the
 * bell for them. When the user opens the list, the active notifications
 * become inactive.
 */
VE.ready(function () {
    var dropdown = document.getElementById('notificationsDropdown');
    var bell = document.getElementById('notificationBell');
    var list = document.getElementById('notificationList');
    var badge = document.getElementById('notificationBadge');
    var seconds = 4; // every xx seconds hit the server
    var pageTitle = document.title;
    var alarmActives = [];
    var actives = [];
    var ring = new Audio(VE.url('/assets/sounds/sounds-1054-suppressed.mp3'));

    var icons = {
        1: ['badge-info', 'fa-home'],      // user assigned to unit
        2: ['badge-success', 'fa-leaf'],   // new volunteer
        4: ['badge-warning', 'fa-calendar'], // action about to expire
        5: ['badge-danger', 'fa-calendar']   // action expired
    };

    function setSum(count) {
        Array.prototype.forEach.call(document.querySelectorAll('.notificationSum'), function (el) { el.textContent = count; });
    }

    function isOpen() {
        return dropdown && dropdown.classList.contains('open');
    }

    function draw(data) {
        actives = [];
        alarmActives = [];
        if (!data || !data.length) return;

        var html = data.map(function (notification) {
            var active = notification.status === 'alarmAndActive' || notification.status === 'active';
            var icon = icons[notification.type_id] || ['badge-info', 'fa-info'];
            if (notification.status === 'alarmAndActive') alarmActives.push(notification.id);
            if (active) actives.push(notification.id);
            return '<li class="' + (active ? 'grey' : 'white') + '"><a href="' + VE.esc(VE.base() + notification.url) + '">' +
                '<div class="task-icon badge ' + icon[0] + '"><i class="fa ' + icon[1] + '"></i></div>' +
                '<p class="task-details">' + VE.esc(notification.msg) + ' <small><em>(' + VE.esc(notification.when) + ')</em></small></p>' +
                '</a></li>';
        }).join('');

        // if there are new notifications, play a sound
        if (alarmActives.length > 0) {
            var playing = ring.play();
            if (playing && playing.catch) playing.catch(function () { /* the browser can block the sound */ });
        }

        if (actives.length > 0) {
            setSum(actives.length);
            if (badge) VE.show(badge);
            document.title = '(' + actives.length + ') ' + pageTitle;
        } else {
            setSum(0);
            if (badge) VE.hide(badge);
            document.title = pageTitle;
        }
        if (list) list.innerHTML = html;
    }

    // for each new notification, tell the server to stop the bell
    function stopBellNotification() {
        alarmActives.forEach(function (id) {
            VE.http.post('/stopBellNotification/' + id).catch(function (error) { console.error(error); });
        });
    }

    function timer() {
        // do not change the list while the user reads it
        if (!isOpen()) {
            VE.http.get('/checkForNotifications')
                .then(function (data) {
                    draw(data);
                    stopBellNotification();
                })
                .catch(function (error) {
                    // a request cut off by leaving the page is not an error
                    if (!(error instanceof TypeError)) console.error(error);
                });
        }
        setTimeout(timer, seconds * 1000);
    }

    if (dropdown) timer();

    // when the user opens the list, the active notifications become inactive
    // (capture phase: read the state before the dropdown toggles it)
    if (bell) {
        document.addEventListener('click', function (event) {
            if (!event.target.closest || !event.target.closest('#notificationBell')) return;
            if (isOpen()) return;
            actives.forEach(function (id) {
                VE.http.post('/deactivateNotification/' + id).catch(function (error) { console.error(error); });
            });
            document.title = pageTitle;
            if (badge) VE.hide(badge);
        }, true);
    }

    // easter egg: click the logo more than 10 times
    var logoCounter = 0;
    var egg = document.getElementById('easterEgg');
    VE.on(document, 'click', '.navbar .logo-box img', function () {
        logoCounter++;
        if (logoCounter > 10 && egg) VE.show(egg);
    });
    if (egg) {
        egg.addEventListener('click', function () {
            VE.hide(egg);
            logoCounter = 0;
        });
    }
});
