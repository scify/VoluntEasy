(function(){

    var initBirthDayDatepicker = function() {
        $('input[name="birth_date"]').datepicker({
            language: 'el',
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    };

    var setDateHiddenField = function () {
        var day = $(".date-day").find("select").val();
        var month = $(".date-month").find("select").val();
        var year = $(".date-year").find("select").val();

        var date = "";

        if(day != "" && month != "" && year != ""){
            date = day + "/" + month + "/" + year;
        }

        $("input[name='birth_date']").val(date);
    };

    var toggleFieldset = function(fieldset) {
        if ($(fieldset).is('.collapsed')) {
            // Action div containers are processed separately because of a IE bug
            // that alters the default submit button behavior.
            var content = $('> div:not(.action)', fieldset);
            $(fieldset).removeClass('collapsed');
            content.hide();
            content.slideDown( {
                duration: 'fast',
                easing: 'linear',
                complete: function() {
                    collapseScrollIntoView(this.parentNode);
                    this.parentNode.animating = false;
                    $('div.action', fieldset).show();
                },
                step: function() {
                    // Scroll the fieldset into view
                    collapseScrollIntoView(this.parentNode);
                }
            });
        }
        else {
            $('div.action', fieldset).hide();
            var content = $('> div:not(.action)', fieldset).slideUp('fast', function() {
                $(this.parentNode).addClass('collapsed');
                this.parentNode.animating = false;
            });
        }
    };

    /**
     * Scroll a given fieldset into view as much as possible.
     */
    var collapseScrollIntoView = function (node) {
        var h = self.innerHeight || document.documentElement.clientHeight || $('body')[0].clientHeight || 0;
        var offset = self.pageYOffset || document.documentElement.scrollTop || $('body')[0].scrollTop || 0;
        var posY = $(node).offset().top;
        var fudge = 55;
        if (posY + node.offsetHeight + fudge > h + offset) {
            if (node.offsetHeight > h) {
                window.scrollTo(0, posY);
            } else {
                window.scrollTo(0, posY + node.offsetHeight - h + fudge);
            }
        }
    };

    var initLegendsCollapse = function(){
        $('fieldset.collapsible > legend:not(.collapse-processed)').each(function() {
            var fieldset = $(this.parentNode);
            // Expand if there are errors inside
            if ($('input.error, textarea.error, select.error', fieldset).size() > 0) {
                fieldset.removeClass('collapsed');
            }

            // Turn the legend into a clickable link and wrap the contents of the fieldset
            // in a div for easier animation
            var text = this.innerHTML;
            $(this).empty().append($('<a href="#">'+ text +'</a>').click(function() {
                var fieldset = $(this).parents('fieldset:first')[0];
                // Don't animate multiple times
                if (!fieldset.animating) {
                    fieldset.animating = true;
                    toggleFieldset(fieldset);
                }
                return false;
            }))
                .after($('<div class="fieldset-wrapper"></div>')
                    .append(fieldset.children(':not(legend):not(.action)')))
                .addClass('collapse-processed');
        });
    };

    var initTextareaGrippies = function(){
        // set textareas grippie style
        $('textarea.resizable:not(.textarea-processed)').each(function() {
            // Avoid non-processed teasers.
            if ($(this).is(('textarea.teaser:not(.teaser-processed)'))) {
                return false;
            }

            var textarea = $(this).addClass('textarea-processed'), staticOffset = null;

            $(this).wrap('<div class="resizable-textarea"><span></span></div>')
                .parent().append($('<div class="grippie"></div>').mousedown(startDrag));

            var grippie = $('div.grippie', $(this).parent())[0];
            grippie.style.marginRight = (grippie.offsetWidth - $(this)[0].offsetWidth) + 'px';

            function startDrag(e) {
                staticOffset = textarea.height() - e.pageY;
                textarea.css('opacity', 0.25);
                $(document).mousemove(performDrag).mouseup(endDrag);
                return false;
            }

            function performDrag(e) {
                textarea.height(Math.max(32, staticOffset + e.pageY) + 'px');
                return false;
            }

            function endDrag(e) {
                $(document).unbind("mousemove", performDrag).unbind("mouseup", endDrag);
                textarea.css('opacity', 1);
            }
        });
    };

    var init = function(){
        initLegendsCollapse();
        initTextareaGrippies();
        initBirthDayDatepicker();
    };

    $(function(){
        init();
    });
})();
