(function(){

    var displayOrHideOtherEducationField = function() {
        //if selected item is the last one display the field, else hide it
        if ($(this).val() === $("select[name='education_level_id']").find("option").last().val()) {
            $("#other_education_wrapper").removeClass("hide");
        } else {
            $("#other_education_wrapper").addClass("hide");
        }
    };

    var initBirthDayDatepicker = function() {
        $('input[name="birth_date"]').datepicker({
            language: 'el',
            format: 'dd/mm/yyyy',
            autoclose: true
        });
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

    var displayTextAreasOldValues = function(){
        $("textarea").each(function(){
            var oldValue = $(this).data("val");
            $(this).text(oldValue);
        });
    };

    var displaySelectOldValues = function(){
        $("select").each(function(){
            var oldValue = $(this).data("val");
            if(typeof oldValue != 'undefined' && oldValue !== "") {
                $(this).val(oldValue);
            }
        });
    };

    var displayGenderOldValue = function(){
        var oldValue = $("#genders-wrapper").data("val");
        $("input[name='gender_id']").each(function(){
            if ($(this).val() == oldValue) {
                $(this).prop('checked', true);
            }
        });
    };

    var displayCheckboxesOldValues = function(){
        $("input[type='checkbox']").each(function(){
            var oldValue = $(this).data("val");
            if(typeof oldValue != 'undefined' && oldValue !== "") {
                $(this).prop('checked', true);
            }
        });
    };

    var displayLangRadioButtonsOldValues = function(){
        $(".language").each(function(){
            var oldValue = $(this).data("val");
            $(this).find("input").each(function(){
                if($(this).val() == oldValue) {
                    $(this).prop('checked', true);
                }
            });
        });
    };

    var clearLanguageSelection = function(){
        $(this).siblings(".form-item").find("input").each(function(){
            $(this).prop('checked', false);
        });
    };

    var init = function(){
        initLegendsCollapse();
        initTextareaGrippies();
        initBirthDayDatepicker();
        $("select[name='education_level_id']").change(displayOrHideOtherEducationField);
        displayTextAreasOldValues();
        displaySelectOldValues();
        displayGenderOldValue();
        displayCheckboxesOldValues();
        displayLangRadioButtonsOldValues();
        $(".clear-language").click(clearLanguageSelection);
    };

    $(function(){
        init();
    });
})();
