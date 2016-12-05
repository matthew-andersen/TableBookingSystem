// JavaScript for handling events

xhttp = new XMLHttpRequest();

var userOrder = [];
var roomList = [];

var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);
var onScreenDate = moment([currentYear, currentMonth, currentDay, currentHour]);


// Initialises the application on page load
document.addEventListener('DOMContentLoaded', function roomGen() {
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
    xmlhttp.open("GET", "process.php?q=", true);
    xmlhttp.send();
});

function listHandle(workspaceList) {
    workspaceList = workspaceList.split(",");
    for (var count = 2; count < workspaceList.length + 1; count += 2) {
        colourChange(workspaceList.slice(count - 2, count))
    }
}

function colourChange(workspaceInfo) {
    var roomID = workspaceInfo[0];
    var room = document.getElementById(roomID);
    if (workspaceInfo[1] == 1) {
        room.style.fill = "green";
    } else if (workspaceInfo[1] == 0) {
        room.style.fill = "red";
    }
}

function initialiseDate() {
    // TODO: alert(currentDateTime.format("Y,M,D,HH"))
    document.getElementById("date-display-box").innerHTML = moment(onScreenDate).format('MMMM Do YYYY - h:00a');
}

function handleLocationSelection(name, location) {
// Function checks if location has been booked and if it is not it allows the user to make a booking also includes basic error checking
// The booking is then confirmed by the user and the location is 'redded-out'
// This may not be the best function name, but it will do for now
    var room_svg_object = document.getElementById(name);
    if (room_svg_object.style.fill == "red") {
        alert("Sorry, this has been booked");
    } else if (room_svg_object.style.fill == "yellow") {
        alert("This booking needs to be confirmed")
    } else {
        var days = window.prompt("Enter how many days").trim();
        if (days != "" && days != null) {
            var cost = days * 25;
            if (window.confirm("Your booking is for " + days + " days. This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {
                document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + location + " for " + days + " days: $" + cost + "</p>";
                //text(location + " for " + days + " days: $" + cost);
                //$("#cart-box").text(location + " for " + days + " days: $" + cost);
                room_svg_object.style.fill = "yellow";
                userOrder.push(name);
            }
        }
        else {
            window.alert("Please enter a valid booking duration")
        }
    }
}

function submitOrder() {
    for (var i = 0; i < userOrder.length; i++) {
        alert(userOrder[i]);
        // document.getElementById(userOrder[i]).style.fill = "red"
        xmlhttp.open("GET", "orderprocess.php?q=" + userOrder[i], true);
        xmlhttp.send();
        alert("Thank you for your booking!");
        $("#cart-box-order").text("")

    }
}

// function arraysEqual(arr1, arr2) {
//     if (arr1.length !== arr2.length)
//         return false;
//     for (var i = arr1.length; i--;) {
//         if (arr1[i] !== arr2[i])
//             return false;
//     }
//     return true;
// }

function dayBackCheck(onScreenDate, currentDate) {
    if (onScreenDate.year)

        for (var i = 0; i < 3; i++) {
            if (onScreenDate[i] > currentDate[i]) {
                return true;
            }
        }
    return false;
}

function hourBackCheck(onScreenDate, currentDate) {
    for (var i = 0; i < 4; i++) {
        if (onScreenDate[i] > currentDate[i]) {
            return true;
        }
    }
    return false;
}

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
        // onScreenDate[3] = onScreenDate[3] + 1;
        // if (moment(onScreenDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
        //     onScreenDate[2] = onScreenDate[2] + 1;
        //     onScreenDate[3] = 0
        // }
    } else if (change == "dayForward") {
        onScreenDate.add(1, 'days');
    }
    document.getElementById("date-display-box").innerHTML = onScreenDate.format('MMMM Do YYYY - h:00a');
}