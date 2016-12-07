// JavaScript for handling events

// XMLHttp object is used to communicate with the server without refreshing the page
xhttp = new XMLHttpRequest();

// Global variables for various colours of the SVG objects
var AVAILABLE = "rgb(94, 172, 95)";
var UNAVAILABLE = "rgb(223, 223, 223)";
var SELECTED = "rgb(41, 145, 42)";

// List that stores all the selected rooms of the user
var userOrder = [];
// var roomList = [];

// Global variables to handle date/time - both current and onscreen date/time
var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);
var onScreenDate = moment([currentYear, currentMonth, currentDay, currentHour]);


// Initialises the application on page load/refresh
// Sets the date, and displays room availability via colouring
$(document).ready(function roomGen() {
    initialiseDate();
    var currentBookings = getBookings();
    updateView(currentBookings, onScreenDate);
});

// // Used to turn data received from the database into a list which can be used to change the colour of room objects
// function listHandle(workspaceList) {
//     workspaceList = workspaceList.split(",");
//     for (var count = 2; count < workspaceList.length + 1; count += 2) {
//         colourChange(workspaceList.slice(count - 2, count))
//     }
// }

// Changes colour of room based on availability
// function colourChange(workspaceInfo) {
//     var roomID = workspaceInfo[0];
//     var room = document.getElementById(roomID);
//     if (workspaceInfo[1] == 1) {
//         room.style.fill = AVAILABLE;
//     } else if (workspaceInfo[1] == 0) {
//         room.style.fill = UNAVAILABLE;
//     }
// }

/* Sets 'datebox' div to contain the current date*/
function initialiseDate() {
    // TODO: alert(currentDateTime.format("Y,M,D,HH"))
    document.getElementById("date-display-box").innerHTML = moment(onScreenDate).format('MMMM Do YYYY - h:00a');
}

// Function checks if location has been booked and if it is not it allows the user to make a booking also includes basic error checking
// The booking is then confirmed by the user and the location is 'greyed-out'
function handleLocationSelection(name, location) {
    var room_svg_object = document.getElementById(name);
    if (room_svg_object.style.fill == UNAVAILABLE) {
        alert("Sorry, this has been booked");
    } else if (room_svg_object.style.fill == SELECTED) {
        alert("This booking needs to be confirmed")
    } else {
        var days = window.prompt("Enter how many days").trim();
        if (days != "" && days != null) {
            var cost = days * 25;
            if (window.confirm("Your booking is for " + days + " days. This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {
                document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + location + " for " + days + " days: $" + cost + "</p>";
                //text(location + " for " + days + " days: $" + cost);
                //$("#cart-box").text(location + " for " + days + " days: $" + cost);
                room_svg_object.style.fill = SELECTED;
                var bookingDateTime = onScreenDate.clone();
                bookingDateTime.add(days, 'days');

                // userOrder.push(['3', currentDateTime.format('YYYY MM DD HH'), '14', days, '24', '0', onScreenDate.format('YYYY MM DD HH'), bookingDateTime.format('YYYY MM DD HH'), name]);
                alert(userOrder);
            }
        }
        else {
            window.alert("Please enter a valid booking duration")
        }
    }
}

// Sends all the rooms the user ordered to be processed then resets the 'cart' and reloads the page
function submitOrder() {
    for (var i = 0; i < userOrder.length; i++) {
        alert(userOrder[i]);
        // document.getElementById(userOrder[i]).style.fill = UNAVAILABLE
        //TODO: Here is where we need to send the record (booking_id, table_id, onScreenDate, duration, user_id) to a new record table
        xmlhttp.open("GET", "order_process.php?q=" + userOrder[i], true);
        xmlhttp.send();
        alert("Thank you for your booking!");
        $("#cart-box-order").text("");
        location.reload();

    }
}

// Essentially the Magnum Opus of this JS file... lmao
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
            } else onScreenDate = currentDateTime.clone();
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

function updateView(bookings, onScreenDate) {
    for (var i = 0; i < bookings.length; i++){
        var startDatetimeString = bookings[i][1];
        var endDatetimeString = bookings[i][2];

        var startDateTime = moment(startDatetimeString, "YYYY-MM-DD HH:mm:ss");
        var endDateTime = moment(endDatetimeString, "YYYY-MM-DD HH:mm:ss");

        var locationElement = document.getElementById(bookings[i][0]);
        if (onScreenDate.isBetween(startDateTime, endDateTime) || onScreenDate.isSame(startDateTime)){
            locationElement.style.fill = "red";
        }
        else {
            locationElement.style.fill = "green";
        }
    }
}

//returns an array of bookings from the database, each booking is its own array with location, start datetime of booking and end datetime of booking
function getBookings(){
    //final array where each booking is its own array
    var arrayBookings = [];

    var newRequest = new XMLHttpRequest();
    //when the request loads, run this anonymous function
    newRequest.onload = function () {
        //what to you want to do with the response?
        var strBookings = this.responseText.replace("\"", "").split("|");
        for(var i = 0; i < strBookings.length - 1; i++){
            var arrayBooking = strBookings[i].split(",");
            arrayBookings.push(arrayBooking);
        }
    };
    //open the file to make the request. Need to be false so program execution halts until response is ready
    newRequest.open("get", "update_availability.php", false);

    newRequest.send();
    return arrayBookings;
}