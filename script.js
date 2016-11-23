// JavaScript for handling events

function handleLocationSelection(name) {
// Function checks if location has been booked and if it is not it allows the user to make a booking also includes basic error checking
// The booking is then confirmed by the user and the location is 'redded-out'
// This may not be the best function name, but it will do for now
    var f = document.getElementById(name);
    if (f.style.fill == "red") {
        alert("Sorry, this has been booked");
    } else {
        var days = window.prompt("Enter how many days");
        if (days != "") {
            var cost = days * 25;
            if (window.confirm("Your booking is for " + days + " days. This will cost a total of: $" + cost + ". Press OK to confirm.") == true) {
                f.style.fill = "red";
            }
        }
        else {
            window.alert("Please enter a booking duration")
        }
    }
}