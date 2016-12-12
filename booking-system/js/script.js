// JavaScript for handling events
// XMLHttp object is used to communicate with the server without refreshing the page
xhttp = new XMLHttpRequest();
var newRequest = new XMLHttpRequest();

// Global variables for various colours of the SVG objects
var AVAILABLE = "rgb(94, 172, 95)";
var UNAVAILABLE = "rgb(165, 165, 140)";
var SELECTED = "rgb(41, 145, 42)";

var roomList = ['room_1', 'room_2', 'room_3', 'room_4', 'desk_1', 'desk_2', 'desk_3', 'desk_4', 'desk_5', 'desk_6', 'desk_7', 'desk_8'];
// List that stores all the selected rooms of the user
var userOrder = [];

// Global variables to handle date/time - both current and onscreen date/time
var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);
var onScreenDate = [currentYear, currentMonth, currentDay, currentHour];

//Updates banked days/hours for user any time they make a booking/refresh the page
function updateUserInfoView(userInfo) {
    var spanTags = document.getElementsByTagName("SPAN");
    for (var i = 1; i < userInfo.length; i++) {
        spanTags[i - 1].innerHTML = spanTags[i - 1].innerHTML + userInfo[i];
    }
}

// Initialises the application on page load/refresh
// Sets the date, updates the view based on availabilities, updates the user's account information
$(document).ready(function roomGen() {
    alert(onScreenDate);
    initialiseDate();
    calendar();
    var currentBookings = getBookings();
    updateView(currentBookings, onScreenDate);
    var userInfo = getUserAccount();
    updateUserInfoView(userInfo);
});

// Sets 'datebox' div to contain the current date //
function initialiseDate() {
    // TODO: alert(currentDateTime.format("Y,M,D,HH"))
    document.getElementById("date-display-box").innerHTML = moment(onScreenDate).format('MMMM Do YYYY - h:00a');
}

//Returns true if the first parameter is a positive number smaller than or equal to the second parameter
function isValidNumDays(days, numDaysRemaining) {
    //returns true if days is a number, greater than 0 and within the num of days left to the user.
    // return (!isNaN(days) && (days > 0) && (days <= numDaysRemaining));
    days = parseInt(days);
    numDaysRemaining = parseInt(numDaysRemaining);
    if (isNaN(days) || days <= 0) {
        alert("Please enter a valid number of days.");
        return false;
    }
    else if (days > numDaysRemaining) {
        alert("You do not have enough time in your account for this booking.");
        return false;
    }
    else {
        return true;
    }
}

// Function checks if location has been booked and if it is not it allows the user to make a booking also includes basic error checking
// The booking is then confirmed by the user and the location is 'greyed-out'
function handleLocationSelection(name, location) {
    var room_svg_object = document.getElementById(name);
    if (room_svg_object.style.fill == UNAVAILABLE) {
        alert("Sorry, this has been booked");
    } else if (room_svg_object.style.fill == SELECTED) {
        alert("This booking needs to be confirmed");
    } else {
        // Get the user account information from the database;
        var accountInfo = getUserAccount();
        var numDaysRemaining = accountInfo[1];

        //Ask user how long they would like to book for
        var days = window.prompt("Enter how many days").trim();
        if (isValidNumDays(days, numDaysRemaining)) {
            var cost = days * 25;
            //calculate the end datetime of the booking
            var bookingDateTime = onScreenDate.clone();
            bookingDateTime.add(days, 'days');

            //if it does not conflict with existing bookings
            if (isValidEndDatetime(bookingDateTime, name)) {
                //if user confirms addition to cart
                if (window.confirm("Your booking is for " + days + " days. This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {

                    room_svg_object.style.fill = SELECTED;

                    //pushing: user_id, date_created, num_days, num_desk_hours, num_room_hours, start_datetime, end_datetime, location_id
                    //populate the list with relevant order information for sending to database
                    userOrder.push(['4', currentDateTime.format('YYYYMMDD'), '14', days.toString(), '24', '0', onScreenDate.format('YYYY-MM-DD HH:mm:ss'), bookingDateTime.format('YYYY-MM-DD HH:mm:ss'), name]);

                    //add to cart
                    document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + location + " for " + days + " days: $" + cost + "</p>";
                }
            }
            else {
                alert("This booking conflicts with a later booking. Please make sure the entire booking duration is available.");
            }
        }
    }
}

// Checks whether passed date does not conflict with existing bookings
function isValidEndDatetime(bookingEndDatetime, location) {
    bookingEndDatetime = moment(bookingEndDatetime, "YYYY-MM-DD HH:mm:ss");
    var currentBookings = getBookings();
    for (var i = 0; i < currentBookings.length; i++) {
        var startDatetimeString = currentBookings[i][1];
        var endDatetimeString = currentBookings[i][2];
        var bookingLocation = currentBookings[i][0];

        var startDateTime = moment(startDatetimeString, "YYYY-MM-DD HH:mm:ss");
        var endDateTime = moment(endDatetimeString, "YYYY-MM-DD HH:mm:ss");
        //if this iteration's booking pertains to the location trying to be booked
        if (bookingLocation == location) {
            ;            // If the end datetime of this potential booking conflicts with an existing booking
            if (bookingEndDatetime.isBetween(startDateTime, endDateTime) || bookingEndDatetime.isSame(endDateTime)) {
                return false;
            }
        }
    }
    //booking must be valid
    return true;
}

function getUserAccount() {
    var userRequest = new XMLHttpRequest();
    var userAccountInfo;
    // When the request loads, run this anonymous function
    userRequest.onload = function () {
        // What to you want to do with the response?
        userAccountInfo = this.responseText.split(',');
    };

    // Open the file to make the request. Need to be false so program execution halts until response is ready
    userRequest.open("GET", "php/get_user_account.php", false);
    userRequest.send();

    return userAccountInfo;
}

// Sends all the rooms the user ordered to be processed then resets the 'cart' and reloads the page
function submitOrder() {
    //sends order information to booking records
    $.ajax({
        url: 'php/order_process.php',
        type: 'POST',
        data: {'q': JSON.stringify(userOrder)}
    });

    alert("Thank you for your booking!");
    $("#cart-box-order").text("");
    location.reload();

    //user order indices: 3, 4, 5
    var numDays = userOrder[0][3];
    var numDeskHours = userOrder[0][4];
    var numRoomHours = userOrder[0][5];
    // alert(numDays + " " + numDeskHours + " " + numRoomHours);
    var currentAccountInfo = getUserAccount();
    if (numDays != 0) {
        currentAccountInfo[1] -= numDays;
    }
    //UNCOMMENT WHEN NEEDED
    // else if (numDeskHours != 0){
    //     currentAccountInfo[2] -= numDeskHours;
    // }
    // else if (numRoomHours != 0){
    //     currentAccountInfo[3] -= numRoomHours;
    // }

    //sends updated account information to user table
    $.ajax({
        url: 'php/update_user_account.php',
        type: 'POST',
        data: {'q': JSON.stringify(currentAccountInfo)}
    });
}

function calendar() {
    $("#datepicker").datepicker();
    $("#datepicker").on("change",function(){
        var selected = $(this).val();
        selected = selected.split("/");
/*        selected.split()*/
        // alert(onScreenDate);
        onScreenTime = onScreenDate.format('HH');
        // onScreenDate = [selected[2], selected[1], selected[0]-1, onScreenTime];
        onScreenDate = moment([selected[2], selected[1], selected[0]-1, onScreenTime]);
        alert([selected[2], selected[0]-1, selected[1], onScreenTime]);
        document.getElementById("date-display-box").innerHTML = onScreenDate.format('MMMM Do YYYY - h:00a');
    });
}

// Used to go back/forward in day/time - won't allow the user to go behind the current time
function changeDate(change) {
    if (change == "hourBack" && onScreenDate.isAfter(currentDateTime, 'hour')) {
        onScreenDate.add(-1, 'hours');
    } else if (change == "dayBack" && (onScreenDate.isAfter(currentDateTime, 'day'))) {
        var potentialNewDate = onScreenDate.clone();
        potentialNewDate.add(-1, 'days');
        if (potentialNewDate.isSame(currentDateTime, 'day')) {
            if (potentialNewDate.isSameOrAfter(onScreenDate, 'hour')) {
                onScreenDate.add(-1, 'days');
            }
            //send user back to current time, no further
            else onScreenDate = currentDateTime.clone();
        } else {
            onScreenDate.add(-1, 'days');
        }
    } else if (change == "hourForward") {
        onScreenDate.add(1, 'hours');

    } else if (change == "dayForward") {
        onScreenDate.add(1, 'days');
    }
    document.getElementById("date-display-box").innerHTML = onScreenDate.format('MMMM Do YYYY - h:00a');
    var bookings = getBookings();
    updateView(bookings, onScreenDate);
}

//updates map based on bookings recorded in database
function updateView(bookings, onScreenDate) {
    for (var i = 0; i < roomList.length; i++) {
        document.getElementById(roomList[i]).style.fill = AVAILABLE;
    }

    for (i = 0; i < bookings.length; i++) {
        var startDatetimeString = bookings[i][1];
        var endDatetimeString = bookings[i][2];

        var startDateTime = moment(startDatetimeString, "YYYY-MM-DD HH:mm:ss");
        var endDateTime = moment(endDatetimeString, "YYYY-MM-DD HH:mm:ss");

        var locationElement = document.getElementById(bookings[i][0]);
        if (onScreenDate.isBetween(startDateTime, endDateTime) || onScreenDate.isSame(startDateTime)) {
            locationElement.style.fill = UNAVAILABLE;
        }
    }
}

// Returns an array of bookings from the database, each booking is its own array with location, start datetime of booking and end datetime of booking
function getBookings() {
    //final array where each booking is its own array
    var arrayBookings = [];

    // When the request loads, run this anonymous function
    newRequest.onload = function () {
        //what to you want to do with the response?
        var strBookings = this.responseText.replace("\"", "").split("|");
        for (var i = 0; i < strBookings.length - 1; i++) {
            var arrayBooking = strBookings[i].split(",");
            arrayBookings.push(arrayBooking);
        }
    };
    // Open the file to make the request. Need to be false so program execution halts until response is ready
    newRequest.open("GET", "php/update_availability.php", false);

    newRequest.send();
    return arrayBookings;
}