/**
 * All the scripts that initialize the autocompletes and other widjets of the search.
 */

/*** Slider for the age range ***/
$("#age-slider-range").slider({
    range: true,
    min: 0,
    max: 100,
    values: [18, 45],
    slide: function (event, ui) {
        $("#age").val(ui.values[0] + "-" + ui.values[1]);
        $("#age-range").val(ui.values[0] + "-" + ui.values[1]);
    }
});

$("#age").val($("#age-slider-range").slider("values", 0) + "-" + $("#age-slider-range").slider("values", 1));


/*** City autocomplete ***/
$( "#city" ).autocomplete({
    source: $("body").attr('data-url') + '/search/city',
    minLength: 1
});

/*** Country autocomplete ***/
$( "#country" ).autocomplete({
    source: $("body").attr('data-url') + '/search/country',
    minLength: 1
});
