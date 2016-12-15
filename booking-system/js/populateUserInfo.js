/**Script used to populate user account information (time allocations and confirmed bookings) on the dashboard
 * Created by Draga on 9/12/2016.
 */

//get current datetime from system for use in determining which bookings to display (i.e. won't display bookings in the past)
var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);

var bookingContainer = document.getElementById('bookings');
populateBookings();
populateTimeAllocations();

/**
 * Function gets bookings from the database pertaining to the currently logged in user, and concatenates an
 * appropriate display string then used to populate the "Your Bookings" portion of the dash
 */
function populateBookings() {
    var arrayBookings = [];

    var bookingRequest = new XMLHttpRequest();
    bookingRequest.onload = function () {
        //splits the booking string from the database into strings of the individual bookings
        var strBookings = this.responseText.replace("\"", "").split("|");
        //iterating from 1, first element blank
        for (var i = 1; i < strBookings.length; i++) {
            //split the individual booking strings into arrays of their own for convenience
            var arrayBooking = strBookings[i].split(",");
            arrayBookings.push(arrayBooking);
        }
    };
    bookingRequest.open("GET", "booking-system/php/get_user_bookings.php", false);
    bookingRequest.send();

    for (var i = 0; i < arrayBookings.length; i++) {
        var room_location = arrayBookings[i][0];
        //Modify location string for display from room_x to Room x
        room_location = room_location.replace("_", " ");
        room_location = room_location.charAt(0).toUpperCase() + room_location.slice(1);

        var startDateTime = arrayBookings[i][1];
        var endDateTime = arrayBookings[i][2];
        //convert string type dates into moments for easy formatting and comparison
        momentStart = moment(startDateTime, "YYYY-MM-DD HH:mm:ss");
        momentEnd = moment(endDateTime, "YYYY-MM-DD HH:mm:ss");


        //if the current booking is today or after
        if (momentStart.isSameOrAfter(currentDateTime, 'day')) {
            var formatStart = momentStart.format('dddd, MMMM Do');
            /*
            * Concatenate an appropriate display string e.g.
            * Sunday, December 18th:
            * Room 3, 13:00 - 13:00
            * */
            var bookingString = formatStart + ": " + "<br>" + room_location + ", " + momentStart.format('HH:mm') + " - " + momentEnd.format('HH:mm');
            bookingContainer.innerHTML += "<p>" + bookingString + "</p>";
        }
    }
}

/**
 * Gets time allocations from user account in database pertaining to currently logged in user, populates the appropriate
 * fields on the dash
 */
function populateTimeAllocations() {
    var accountInfo;

    var accountRequest = new XMLHttpRequest();
    accountRequest.onload = function () {
        accountInfo = this.responseText.split(',');
    };
    accountRequest.open("GET", "booking-system/php/get_user_account.php", false);
    accountRequest.send();

    var userName = accountInfo[4];
    var num_desk_hours = accountInfo[1];
    var num_days = accountInfo[2];
    var num_room_hours = accountInfo[3];

    document.getElementById('user').innerHTML = userName;
    document.getElementById('num_desk_hours').innerHTML = num_desk_hours;
    document.getElementById('num_days').innerHTML = num_days;
    document.getElementById('num_room_hours').innerHTML = num_room_hours;

}



