/**
 * Created by Draga on 9/12/2016.
 */
//use this file to get bookings from database (use user_id session variable to retrieve appropriate bookings)
//populate "Current Bookings" with the information
var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);

var bookingContainer = document.getElementById('bookings');

var arrayBookings = [];

var bookingRequest = new XMLHttpRequest();
bookingRequest.onload = function () {
    //what to you want to do with the response?
    var strBookings = this.responseText.replace("\"", "").split("|");
    //iterating from 1, first element blank
    for (var i = 1; i < strBookings.length; i++) {
        var arrayBooking = strBookings[i].split(",");
        arrayBookings.push(arrayBooking);
    }
};
bookingRequest.open("GET", "booking-system/php/get_user_bookings.php", false);
bookingRequest.send();

for (var i = 0; i < arrayBookings.length; i++) {
    var room_location = arrayBookings[i][0];
    room_location = room_location.replace("_", " ");
    room_location = room_location.charAt(0).toUpperCase() + room_location.slice(1);

    var startDateTime = arrayBookings[i][1];
    var endDateTime = arrayBookings[i][2];
    momentStart = moment(startDateTime, "YYYY-MM-DD HH:mm:ss");
    momentEnd = moment(endDateTime, "YYYY-MM-DD HH:mm:ss");

    if (momentStart.isSameOrAfter(currentDateTime, 'day')){
        var formatStart = momentStart.format('dddd, MMMM Do');
        var bookingString = formatStart + ": " + "<br>" + room_location + ", " + momentStart.format('HH:mm') + " - " + momentEnd.format('HH:mm');
        bookingContainer.innerHTML += "<p>" + bookingString + "</p>";
    }
}
