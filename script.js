// JavaScript for handling events

xhttp = new XMLHttpRequest();

var userOrder = [];
var roomList = [];

var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDate = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = [currentYear, currentMonth, currentDate, currentHour];
var completeDate = [currentYear, currentMonth, currentDate, currentHour];


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
    // alert(workspaceInfo);
    var roomID = workspaceInfo[0];
    var room = document.getElementById(roomID);
    if (workspaceInfo[1] == 1) {
        room.style.fill = "green";
    } else if (workspaceInfo[1] == 0) {
        room.style.fill = "red";
    }
}

function initialiseDate() {
    document.getElementById("date-display-box").innerHTML = moment(completeDate).format('MMMM Do YYYY - h:00a');
}

function handleLocationSelection(name, location) {
// Function checks if location has been booked and if it is not it allows the user to make a booking also includes basic error checking
// The booking is then confirmed by the user and the location is 'redded-out'
// This may not be the best function name, but it will do for now
    var room_id = document.getElementById(name);
    if (room_id.style.fill == "red") {
        alert("Sorry, this has been booked");
    } else if (room_id.style.fill == "yellow") {
        alert("This booking needs to be confirmed")
    } else {
        var days = window.prompt("Enter how many days").trim();
        if (days != "" && days != null) {
            var cost = days * 25;
            if (window.confirm("Your booking is for " + days + " days. This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {
                document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + location + " for " + days + " days: $" + cost + "</p>";
                //text(location + " for " + days + " days: $" + cost);
                //$("#cart-box").text(location + " for " + days + " days: $" + cost);
                room_id.style.fill = "yellow";
                userOrder.push(name);
            }
        }
        else {
            window.alert("Please enter a valid booking duration")
        }
    }
}

function submitOrder() {
    var i;
    for (i = 0; i < userOrder.length; i++) {
        // document.getElementById(userOrder[i]).style.fill = "red"
        xmlhttp.open("GET", "orderprocess.php?q=" + userOrder[i], true);
        xmlhttp.send();
    }
    alert("Thank you for your booking!");

    $("#cart-box-order").text("")

}

function arraysEqual(arr1, arr2) {
    if (arr1.length !== arr2.length)
        return false;
    for (var i = arr1.length; i--;) {
        if (arr1[i] !== arr2[i])
            return false;
    }
    return true;
}

function changeDate(change) {
    if (change == "hourBack" && arraysEqual(completeDate, currentDateTime) == false) {
        completeDate[3] = completeDate[3] - 1;
        if (moment(completeDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
            completeDate[3] = 23;
            completeDate[2] = completeDate[2] - 1;
            if (moment(completeDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
                completeDate[1] = completeDate[1] - 1;
                alert(completeDate)
            }
        }

    } else if (change == "dayBack" && arraysEqual(completeDate, currentDateTime) == false) {
        completeDate[2] = completeDate[2] - 1;
        if (moment(completeDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
            completeDate[1] = completeDate[1] - 1;
            completeDate[2] = 3
        }

    } else if (change == "hourForward") {
        completeDate[3] = completeDate[3] + 1;
        if (moment(completeDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
            completeDate[2] = completeDate[2] + 1;
            completeDate[3] = 0
        }
    } else if (change == "dayForward") {
        completeDate[2] = completeDate[2] + 1;
        if (moment(completeDate).format('MMMM Do YYYY - h:00a') == "Invalid date") {
            completeDate[1] = completeDate[1] + 1;
            completeDate[2] = 1
        }
    }
    document.getElementById("date-display-box").innerHTML = moment(completeDate).format('MMMM Do YYYY - h:00a');
}