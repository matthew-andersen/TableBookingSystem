// JavaScript for handling events

var userOrder = [];
var roomList = [];

var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDate = todayDate.getDate();
var currentHour = todayDate.getHours();
var completeDate = [currentYear, currentMonth, currentDate, currentHour];


// Initialises the application on page load
$(document).ready(
    function loadCSV() {
        $.ajax({
            url: 'data.csv',
            dataType: 'text'
        }).done(createRoomList);

        function createRoomList(data) {
            var allInfo = data.split(/\r?\n|\r/);
            for (var line = 0; line < allInfo.length; line++) {
                roomList.push(allInfo[line].split(','));
            }
            initialiseRoom()
        }

        function initialiseRoom() {
            var i;
            for (i = 0; i < roomList.length; i++) {
                var room = document.getElementById(roomList[i][0]);
                if (roomList[i][1] == "false") {
                    room.style.fill = "red"
                } else {
                    room.style.fill = "green"
                }

            }
            initialiseDate()
        }

        function initialiseDate() {
            document.getElementById("date-display-box").innerHTML = moment(completeDate).format('MMMM Do YYYY - h:00a');
        }
    });

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
                userOrder.push(name)
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
        document.getElementById(userOrder[i]).style.fill = "red"
    }
    alert("Thank you for your booking!");
    $("#cart-box-order").text("")

}

function changeDate(change) {
    if (change == "hour_back") {
        completeDate[3] = completeDate[3] - 1;
    } else if (change == "day_back") {
        completeDate[2] = completeDate[2] - 1;
    } else if (change == "hour_forward") {
        completeDate[3] = completeDate[3] + 1;
    } else if (change == "day_forward") {
        completeDate[2] = completeDate[2] + 1;
    }
    document.getElementById("date-display-box").innerHTML = moment(completeDate).format('MMMM Do YYYY - h:00a')
}