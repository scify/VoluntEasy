/**
 * The scripts that initialize the autocompletes and the other widgets of the search forms
 * (volunteers, collaborations). Every widget is optional: it starts only if its element exists.
 */
VE.ready(function () {

    /*** Age range (two number inputs, they replace the old slider) ***/
    var ageFrom = document.getElementById('age-from'),
        ageTo = document.getElementById('age-to'),
        ageRange = document.getElementById('age-range'),
        ageText = document.getElementById('age');

    if (ageFrom && ageTo && ageRange) {
        var updateAge = function () {
            var from = Math.min(Math.max(parseInt(ageFrom.value, 10) || 0, 0), 100),
                to = Math.min(Math.max(parseInt(ageTo.value, 10) || 0, 0), 100);
            if (from > to) {
                var tmp = from;
                from = to;
                to = tmp;
            }
            ageRange.value = from + '-' + to;
            if (ageText) ageText.textContent = from + '-' + to;
        };
        ageFrom.addEventListener('input', updateAge);
        ageTo.addEventListener('input', updateAge);
        updateAge();
    }

    /*** Autocompletes ***/
    var autocompletes = {
        '#collabType': '/search/collabType',
        '.volunteer.search.name': '/search/volunteers/firstName',
        '.volunteer.search.lastName': '/search/volunteers/lastName',
        '.volunteer.search.additionalSkills': '/search/volunteers/additionalSkills',
        '.volunteer.search.extraLang': '/search/volunteers/extraLang',
        '.volunteer.search.workDescription': '/search/volunteers/workDescription',
        '.volunteer.search.specialty': '/search/volunteers/specialty',
        '.volunteer.search.department': '/search/volunteers/department',
        '.volunteer.search.participationΑctions': '/search/volunteers/participationΑctions',
        '.volunteer.search.computerUsageComments': '/search/volunteers/computerUsageComments'
    };

    Object.keys(autocompletes).forEach(function (selector) {
        var inputs = VE.$$(selector);
        if (inputs.length) VE.autocomplete(inputs, autocompletes[selector], {minLength: 3});
    });
});
