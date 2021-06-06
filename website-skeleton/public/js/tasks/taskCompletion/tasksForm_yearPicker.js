//Modifies text input into yearpicker input
$(document).ready(function () {
    $("#datepicker").datepicker({
        format: "yyyy",
        maxDate: 0,
        viewMode: "years",
        minViewMode: "years",
        orientation: "bottom"
    });
});