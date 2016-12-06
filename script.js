// JavaScript for handling events

// XMLHttp object is used to communicate with the server without refreshing the page
xhttp = new XMLHttpRequest();

// Global variables for various colours of the SVG objects
var AVAILABLE = "#29912A";
var UNAVAILABLE = "rgb(223, 223, 223)";
var SELECTED = "#E0CA1F";

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
var onScreenDate = moment([currentYear, currentMonth, currentDay, currentHour])


// Initialises the application on page load/refresh
// Sets the date, and displays room availability via colouring
$(document).ready(function roomGen() {
    initialiseDate();
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            listHandle(this.responseText);
            // document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "availability_process.php?q=", true);
    xmlhttp.send();
});

// Used to turn data received from the database into a list which can be used to change the colour of room objects
function listHandle(workspaceList) {
    workspaceList = workspaceList.split(",");
    for (var count = 2; count < workspaceList.length + 1; count += 2) {
        colourChange(workspaceList.slice(count - 2, count))
    }
}

// Changes colour of room based on availability
function colourChange(workspaceInfo) {
    var roomID = workspaceInfo[0];
    var room = document.getElementById(roomID);
    if (workspaceInfo[1] == 1) {
        room.style.fill = AVAILABLE;
    } else if (workspaceInfo[1] == 0) {
        room.style.fill = UNAVAILABLE;
    }
}

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
                userOrder.push(name);
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
        location.reload()

    }
}

// Essentially the Magnum Opus of this JS file.. lmao
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
}