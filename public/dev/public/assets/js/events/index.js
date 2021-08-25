$(document).ready(function () {
    //$("div#events").alternateScroll({'vertical-bar-class': 'styled-green-v-bar', 'hide-bars': false });

    var event_date = new Date();
    event_date.setHours(0, 0, 0, 0);

    $("#from_date").datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
    });
    $("#to_date").datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
    });
});