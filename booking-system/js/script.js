/**
 * Script handles reponses to events in the booking system application
 *
 */

xhttp = new XMLHttpRequest();
var newRequest = new XMLHttpRequest();


var AVAILABLE = "rgb(94, 172, 95)";
var UNAVAILABLE = "rgb(165, 165, 140)";
var SELECTED = "rgb(41, 145, 42)";

var roomList = ['room_1', 'room_2', 'room_3', 'room_4', 'room_5', 'room_6', 'room_7', 'room_8', 'desk_1', 'desk_2', 'desk_3', 'desk_4', 'desk_5', 'desk_6', 'desk_7', 'desk_8', 'desk_9', 'desk_10', 'desk_11', 'desk_12', 'desk_13', 'desk_14'];
// List that stores all the selected rooms of the user
var userOrder = [];
var currentBookings = [];
updateBookings();
var currentUserInfo = [];
getUserAccount();

var todayDate = new Date();
var currentYear = todayDate.getFullYear();
var currentMonth = todayDate.getMonth();
var currentDay = todayDate.getDate();
var currentHour = todayDate.getHours();
var currentDateTime = moment([currentYear, currentMonth, currentDay, currentHour]);
var onScreenDate = moment([currentYear, currentMonth, currentDay, currentHour]);

var uniqueBookingID = 0;

/**
 * Updates display of banked days/hours for user any time they make a booking/refresh the page
 * @param userInfo the database information retrieved about current user
 */
function updateUserInfoView(userInfo) {
    var spanTags = document.getElementsByTagName("SPAN");
    for (var i = 1; i < userInfo.length; i++) {
        spanTags[i - 1].innerHTML = spanTags[i - 1].innerHTML + userInfo[i];
    }
}

/**
 * Initialises the application on page load/refresh
 * Sets the date, updates the view based on availabilities, updates the user's account information
 */
$(document).ready(function roomGen() {
    initialiseDate();
    calendarHandle();
    updateBookings();
    updateView(currentBookings, onScreenDate);
    getUserAccount();
    updateUserInfoView(currentUserInfo);
});

/**
 * Sets 'datebox' div to contain the current date
 */
function initialiseDate() {
    document.getElementById("date-display-box").innerHTML = moment(onScreenDate).format('MMMM Do YYYY - h:00a');
}

/**
 * Checks whether user's allotted time allows for the desired length of booking, and that desired length of booking is number > 0
 *
 * @param duration desired length of booking
 * @param durationRemaining time left in user's account
 *
 * @returns {boolean} true if duration is number > 0 and < duration remaining
 */
function isValidNumDays(duration, durationRemaining) {
    //returns true if days is a number, greater than 0 and within the num of days left to the user.
    // return (!isNaN(days) && (days > 0) && (days <= numDaysRemaining));
    duration = parseInt(duration);
    durationRemaining = parseInt(durationRemaining);
    var dialogBox = $('#dialog');
    if (isNaN(duration) || duration <= 0) {
        document.getElementById("dialog").innerHTML = "Please enter a valid duration.";
        dialogBox.dialog({
            title: "Invalid Duration",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open');
        return false;
    }
    else if (duration > durationRemaining) {
        document.getElementById("dialog").innerHTML = "You do not have enough time in your account for this booking.";
        dialogBox.dialog({
            title: "Insufficient Time",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open');
        return false;
    }
    else {
        return true;
    }
}

/**
 * Checks the type and current state (available, selected, unavailable) of location the user has clicked and opens
 * context appropriate dialog
 *
 * @param locationID ID used to identify location
 * @param locationName name used to display location title to user
 */
function handlePopup(locationID, locationName) {
    if (locationID.slice(0, 4) == "room") {
        document.getElementById("dialog").innerHTML = "Hours: <input name='duration' type='number' min='1' value='' step='1' class='text' title=''/>";
    } else if (locationID.slice(0, 4) == "desk") {
        document.getElementById("dialog").innerHTML = "<input type='radio' name='time' value='hours' checked> Hours<br> <input type='radio' name='time' value='days'> Days<br><input name='duration' type='number' min='1' value='' class='text' title=''/>";
    }

    var dialogBox = $('#dialog');
    dialogBox.dialog({
        resizable: false,
        autoOpen: false,
        width: 300,
        height: 220,
        modal: true,
        title: "Please Enter A Duration",
        buttons: {
            "OK": function () {
                $(this).dialog("close");
                if ($("input[name='time']:checked").val() == "days") {
                    var days = dialogBox.find('input[name="duration"]').val();
                    handleLocationSelection(locationID, locationName, days, "days")
                } else {
                    var hours = dialogBox.find('input[name="duration"]').val();
                    handleLocationSelection(locationID, locationName, hours, "hours")
                }
            },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });
    var room_svg_object = document.getElementById(locationID);
    if (room_svg_object.style.fill == UNAVAILABLE) {
        document.getElementById("dialog").innerHTML = "Sorry, this has been booked";
        dialogBox.dialog({
            title: "Already Booked",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open')
    } else if (room_svg_object.style.fill == SELECTED) {
        document.getElementById("dialog").innerHTML = "This booking needs to be confirmed";
        dialogBox.dialog({
            title: "Needs Confirmation",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open')
    } else {
        dialogBox.dialog('open');
    }
}


/**
 * Checks the state of clicked location and performs actions as appropriate- either displays error message or adds
 * user's location to cart and order array
 *
 * @param locationID id used to grab appropriate SVG element from HTML
 * @param location name used to display location to user
 * @param duration integer entered by user specifying length of booking
 * @param durationType string specifying hours/days for length of booking
 */
function handleLocationSelection(locationID, location, duration, durationType) {
    var room_svg_object = document.getElementById(locationID);

    // Get the user account information from the database;
    getUserAccount();
    var durationRemaining;
    if (durationType == "hours") {
        if (location.slice(0, 4) == "Room") {
            durationRemaining = currentUserInfo[3];
        }
        else {
            durationRemaining = currentUserInfo[1];
        }
    } else if (durationType == "days") {
        durationRemaining = currentUserInfo[2]
    }

    if (isValidNumDays(duration, durationRemaining)) {
        //calculate the end datetime of the booking

        //if it does not conflict with existing bookings
        var bookingDateTime = onScreenDate.clone();
        bookingDateTime.add(duration, durationType);
        if (isValidEndDatetime(bookingDateTime, locationID)) {
            //if user confirms addition to cart
            // if (window.confirm("Your booking is for " + duration + " " + durationType + ". This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {

            room_svg_object.style.fill = SELECTED;

            var userId = -1;
            var userRequest = new XMLHttpRequest();
            userRequest.onload = function () {
                userId = this.responseText;
            };
            userRequest.open("GET", "../checkUser.php", false);
            userRequest.send();

            //pushing: user_id, date_created, num_days, num_desk_hours, num_room_hours, start_datetime, end_datetime, location_id
            //populate the list with relevant order information for sending to database
            uniqueBookingID++;

            if (durationType == "days") {
                for (var i = 0; i < duration; i++) {
                    var bookingStartDatetime = onScreenDate.clone().add(i, 'days');
                    bookingStartDatetime.hour(8);
                    bookingStartDatetime.minute(30);
                    var bookingEndDatetime = bookingStartDatetime.clone();
                    bookingEndDatetime.hour(18);
                    bookingEndDatetime.minute(0);
                    userOrder.push(['4', currentDateTime.format('YYYYMMDD'), userId, '1', '0', '0', bookingStartDatetime.format('YYYY-MM-DD HH:mm:ss'), bookingEndDatetime.format('YYYY-MM-DD HH:mm:ss'), locationID, uniqueBookingID]);
                }
            } else {
                if (location.slice(0, 4) == "Room") {
                    userOrder.push(['4', currentDateTime.format('YYYYMMDD'), userId, '0', '0', duration.toString(), onScreenDate.format('YYYY-MM-DD HH:mm:ss'), bookingDateTime.format('YYYY-MM-DD HH:mm:ss'), locationID, uniqueBookingID]);
                }
                else {
                    userOrder.push(['4', currentDateTime.format('YYYYMMDD'), userId, '0', duration.toString(), '0', onScreenDate.format('YYYY-MM-DD HH:mm:ss'), bookingDateTime.format('YYYY-MM-DD HH:mm:ss'), locationID, uniqueBookingID]);
                }
            }
            //add to cart
            document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + "<a href='#'" + " id=" + uniqueBookingID + " onclick=removeSingleItem(this.id)>" + "[X]" + "</a> " + location + " for " + duration + " " + durationType + "</p>";
        }
    }
    // }
}

/**
 * Checks whether the desired end of the user's booking clashes with a previously existing booking
 *
 * @param bookingEndDatetime the desired end datetime of the user's booking
 * @param location the desired location of the user's booking
 * @returns {boolean} true if there is no conflict, otherwise false
 */
function isValidEndDatetime(bookingEndDatetime, location) {
    bookingEndDatetime = moment(bookingEndDatetime, "YYYY-MM-DD HH:mm:ss");
    updateBookings();
    var dialogBox = $('#dialog');
    for (var i = 0; i < currentBookings.length; i++) {
        var startDatetimeString = currentBookings[i][1];
        var endDatetimeString = currentBookings[i][2];
        var bookingLocation = currentBookings[i][0];

        var startDateTime = moment(startDatetimeString, "YYYY-MM-DD HH:mm:ss");
        var endDateTime = moment(endDatetimeString, "YYYY-MM-DD HH:mm:ss");
        //if this iteration's booking pertains to the location trying to be booked
        if (bookingLocation == location) {
            // If the end datetime of this potential booking conflicts with an existing booking
            if (bookingEndDatetime.isBetween(startDateTime, endDateTime) || bookingEndDatetime.isSame(endDateTime)) {
                document.getElementById("dialog").innerHTML = "This booking conflicts with a later booking. Please make sure the entire booking duration is available.";
                dialogBox.dialog({
                    title: "Booking Conflict",
                    buttons: {
                        "OK": function () {
                            $(this).dialog("close")
                        }

                    }
                });
                dialogBox.dialog('open');
                return false;
            }
        }
    }
    //booking must be valid
    return true;
}

/**
 * Retrieves user account information from the database based on session user ID
 */
function getUserAccount() {
    var userRequest = new XMLHttpRequest();
    var userAccountInfo;
    userRequest.onload = function () {
        if (this.readyState == 4 && this.status == 200) {
            userAccountInfo = this.responseText.split(',');
            currentUserInfo = userAccountInfo;
        }
    };
    userRequest.open("GET", "php/get_user_account.php", true);
    userRequest.send();
}

/**
 * Sends all the rooms the user ordered to be processed then resets the 'cart' and reloads the page
 */
function submitOrder() {
    var dialogBox = $('#dialog');
    if (userOrder.length > 0) {
        document.getElementById("dialog").innerHTML = "Press Submit to confirm your order";
        dialogBox.dialog({
            title: "Submit Order",
            modal: true,
            buttons: {
                "Submit": function () {
                    $(this).dialog("close");
                    //sends order information to booking records
                    $.ajax({
                        url: 'php/order_process.php',
                        type: 'POST',
                        data: {'q': JSON.stringify(userOrder)}
                    });

                    getUserAccount();
                    for (var i = 0; i < userOrder.length; i++) { //user order indices: 3, 4, 5
                        var numDays = userOrder[i][3];
                        var numDeskHours = userOrder[i][4];
                        var numRoomHours = userOrder[i][5];

                        if (numDays != 0) {
                            currentUserInfo[2] -= numDays;
                        }
                        else if (numDeskHours != 0) {
                            currentUserInfo[1] -= numDeskHours;
                        }
                        else if (numRoomHours != 0) {
                            currentUserInfo[3] -= numRoomHours;
                        }
                    }

                    //sends updated account information to user table
                    $.ajax({
                        url: 'php/update_user_account.php',
                        type: 'POST',
                        data: {'q': JSON.stringify(currentUserInfo)}
                    });

                    $("#cart-box-order").text("");
                    location.reload();
                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });
        dialogBox.dialog('open');
    } else {
        document.getElementById("dialog").innerHTML = "Your cart is empty";
        dialogBox.dialog({
            title: "Empty Cart",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open')
    }
}

function removeSingleItem(bookingID) {
    alert(userOrder);
    for (var i = 0; i < userOrder.length; i++) {
        if (userOrder[i][9] == bookingID) {
            userOrder.splice(i, 1)
        }
    }
    document.getElementById("cart-box-order").innerHTML = "";
    for (i = 0; userOrder.length; i++) {
        uniqueBookingID++;
        var roomString = userOrder[i][8].replace("_", " ");
        roomString = roomString.charAt(0).toUpperCase() + roomString.slice(1);
        var durationType;
        var duration;
        if (userOrder[i][5] != 0) { // If this is a day
            durationType = "days";
            duration = userOrder[i][5]
        } else {
            durationType = "hours";
            duration = userOrder[i][6]
        }
        document.getElementById("cart-box-order").innerHTML = document.getElementById("cart-box-order").innerHTML + "<p>" + "<a href='#'" + " id=" + uniqueBookingID + " onclick=removeSingleItem(this.id)>" + "[X]" + "</a> " + roomString + " for " + duration + " " + durationType + "</p>";
    }


    // for (var i = 0; userOrder.length; i++)
    //     alert(userOrder[i][9]);
    // for (i = 0; userOrder.length; i++)
    //     alert(userOrder[i][9]);
}


/**
 * Confirms whether the user wants to clear current cart selections, and clears them if so
 */
function clearOrder() {
    var dialogBox = $('#dialog');
    if (userOrder.length > 0) {
        document.getElementById("dialog").innerHTML = "Are you sure you wish to clear your cart?";
        dialogBox.dialog({
                title: "Clear Cart",
                buttons: {
                    "Yes": function () {
                        userOrder = [];
                        document.getElementById("cart-box-order").innerHTML = "";
                        $(this).dialog("close");
                        location.reload();
                    },
                    "Cancel": function () {
                        $(this).dialog("close")
                    }
                }
            }
        )
        ;
        dialogBox.dialog('open');
    } else {
        document.getElementById("dialog").innerHTML = "Your cart is empty";
        dialogBox.dialog({
            title: "Empty Cart",
            buttons: {
                "OK": function () {
                    $(this).dialog("close")
                }

            }
        });
        dialogBox.dialog('open')

    }
    return false;
}

/**
 * Selects dates on the calendar, updates the date display box and updates the availability view for the new date
 */
function calendarHandle() {
    var dateToday = new Date();
    var $calendar = $('#calendar');
    $calendar.datepicker({
        inline: true,
        minDate: dateToday
    });

    $calendar.datepicker("setDate", dateToday);
    $calendar.on("change", function () {
        var selected = $(this).val();
        selected = selected.split("/");

        var onScreenTime = onScreenDate.format('HH');
        var calendarDate = selected[1];
        var calendarMonth = selected[0] - 1;
        var calendarYear = selected[2];

        if (calendarDate[0] == 0) {
            calendarDate = calendarDate[1]
        }

        onScreenDate = moment([calendarYear, calendarMonth, calendarDate, onScreenTime]);
        document.getElementById("date-display-box").innerHTML = onScreenDate.format('MMMM Do YYYY - h:00a');
        // var bookings = updateBookings();
        // updateView(bookings, onScreenDate);
        updateBookings();
        updateView(currentBookings, onScreenDate);
    });
}

/**
 * Responds to the four date change buttons available. Won't allow the user to go behind the current time
 *
 * @param change the button clicked by the user
 */
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
    // var bookings = updateBookings();
    // updateView(bookings, onScreenDate);
    updateBookings();
    updateView(currentBookings, onScreenDate);
}

/**
 * updates map based on bookings recorded in database
 *
 * @param bookings current bookings in database
 * @param onScreenDate date currently being displayed to user
 */
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
            if (bookings[i][0] == "room_8") {
                for (i = 0; i < roomList.length; i++) {
                    if (roomList[i].slice(0, 4) == "desk") {
                        document.getElementById(roomList[i]).style.fill = UNAVAILABLE;
                    }
                }
            }
        }
    }
}

/**
 * Populates currentBookings from the database, each booking is its own array with location, start datetime of booking
 * and end datetime of booking
 *
 */
function updateBookings() {
    //final array where each booking is its own array
    var arrayBookings = [];

    // When the request loads, run this anonymous function
    newRequest.onload = function () {
        if (this.readyState == 4 && this.status == 200) { //what to you want to do with the response?
            var strBookings = this.responseText.replace("\"", "").split("|");
            for (var i = 0; i < strBookings.length - 1; i++) {
                var arrayBooking = strBookings[i].split(",");
                arrayBookings.push(arrayBooking);
                currentBookings = arrayBookings;
            }
        }
    };
    // Open the file to make the request. Need to be false so program execution halts until response is ready
    newRequest.open("GET", "php/update_availability.php", true);

    newRequest.send();
}