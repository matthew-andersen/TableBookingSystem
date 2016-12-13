<!--TODO: The rooms/desks need to be properly identified to avoid later confusion-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking System</title>
    <script src="js/moment.js"></script>
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
</head>

<body>

<div id="left-col">
    <div id="filter-box">
        <div id="account-info">
            <img src="images/account-icons/calendar2.png" alt="number of days" height="30" width="30">
            <span class="userInfo" id="numDays"></span>
            <img src="images/account-icons/clock2.png" alt="number of desk hours" height="30" width="30">
            <span class="userInfo" id="numDeskHours"></span>
            <img src="images/account-icons/meeting2.png" alt="number of meeting hours" height="30" width="30">
            <span class="userInfo" id="numRoomHours"></span>
        </div>
        <div id="calendar">
            <p>Date: <input type="text" id="datepicker"></p>
        </div>
    </div>
    <div id="review-box">
        <div id="cart-box">
            <div id="cart-box-header">Your Cart</div>
            <div id="cart-box-order"></div>
        </div>
        <button id="submit-button" onclick="submitOrder()">Buy Now</button>
    </div>
</div>

<div id="right-col">
    <div id="date-nav-box">
        <a href="#"><div id="day-nav-arrow-left" onclick="changeDate('dayBack')"></div></a>
        <a href="#"><div id="hour-nav-arrow-left" onclick="changeDate('hourBack')"></div></a>
        <a><div id="date-display-box"></div></a>
        <a href="#"><div id="day-nav-arrow-right" onclick="changeDate('dayForward')"></div></a>
        <a href="#"><div id="hour-nav-arrow-right" onclick="changeDate('hourForward')"></div></a>
    </div>


    <div id="dialog" title="Please Enter a Duration" hidden>
    </div>

    <svg height="698pt" preserveaspectratio="xMidYMid meet" version="1.0" viewbox="0 0 971 698"
         xmlns="http://www.w3.org/2000/svg">

        <!--SVG coordinates for map outline. Make sure to overwrite this if changing the floor plan.-->
        <g fill="#000000" stroke="none" transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)">
            <path
                d="M4850 4910 l0 -1690 660 0 660 0 0 30 0 30 -630 0 -630 0 0 575 0 575 780 0 780 0 0 -585 0 -585 30 0 30 0 0 585 0 585 440 0 440 0 0 -357 -1 -358 -212 -218 -212 -217 -77 0 -78 0 0 -30 0 -30 93 0 92 0 228 228 227 227 0 1118 0 1117 560 0 560 0 0 30 0 30 -620 0 -620 0 0 -30 c0 -27 3 -30 30 -30 l30 0 0 -710 0 -710 -355 0 -355 0 0 710 0 710 140 0 140 0 0 30 0 30 -140 0 -140 0 0 65 0 65 -30 0 -30 0 0 -805 0 -805 -380 0 -380 0 0 1025 0 1025 380 0 380 0 0 -40 c0 -38 2 -40 30 -40 l30 0 0 70 0 70 -485 0 -485 0 0 -30 c0 -29 2 -30 45 -30 l45 0 0 -1025 0 -1025 -455 0 -455 0 0 1025 0 1025 225 0 225 0 0 30 0 30 -255 0 -255 0 0 -1690z"></path>
            <path
                d="M8890 5940 c0 -30 0 -30 58 -30 l57 0 108 -108 107 -107 0 -283 0 -282 -348 0 -348 0 -66 -117 -66 -118 21 -17 c12 -9 24 -15 28 -12 4 2 32 49 63 104 l57 100 330 0 329 0 0 -710 0 -710 -545 0 -545 0 0 273 0 273 80 199 c44 109 79 199 77 200 -10 9 -49 26 -52 23 -2 -2 -40 -94 -84 -206 l-81 -202 0 -375 0 -375 30 0 30 0 0 65 0 65 545 0 545 0 0 -490 0 -490 -545 0 -545 0 0 285 0 285 -30 0 -30 0 0 -285 0 -285 -260 0 -260 0 0 -45 c0 -43 1 -45 30 -45 20 0 30 5 30 15 0 13 96 15 805 15 l805 0 0 -1045 0 -1046 -122 6 c-68 3 -361 12 -653 20 -291 8 -599 17 -682 21 l-153 6 0 339 0 339 -30 0 -30 0 0 -342 0 -341 -250 6 -250 7 0 -29 0 -29 173 -6 c337 -13 2049 -57 2053 -53 2 2 4 1200 4 2663 l0 2659 -122 122 -123 123 -72 0 -73 0 0 -30z"></path>
            <path
                d="M380 3150 c0 -2384 1 -2510 18 -2510 9 0 1340 -36 2957 -80 1617 -44 2971 -80 3008 -80 l68 0 -3 27 c-3 26 -6 28 -58 31 -46 2 -4456 122 -4489 122 -8 0 -11 134 -11 450 l0 450 1100 0 1100 0 0 1325 0 1325 -195 0 c-167 0 -195 2 -195 15 0 13 -187 15 -1620 15 l-1620 0 0 680 0 680 1975 0 1975 0 0 30 0 30 -2005 0 -2005 0 0 -2510z m1460 215 l0 -815 -700 0 -700 0 0 815 0 815 700 0 700 0 0 -815z m410 780 l0 -35 510 0 510 0 0 35 0 35 385 0 385 0 0 -1295 0 -1295 -1085 0 -1085 0 0 1295 0 1295 190 0 190 0 0 -35z m990 15 c0 -20 -7 -20 -480 -20 -473 0 -480 0 -480 20 0 20 7 20 480 20 473 0 480 0 480 -20z m-1400 -2565 l0 -925 -47 0 c-107 -1 -1290 32 -1320 36 l-33 5 0 904 0 905 700 0 700 0 0 -925z"></path>
            <path
                d="M3450 3245 l0 -535 245 0 245 0 0 535 0 535 -245 0 -245 0 0 -535z m230 350 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z"></path>
            <path
                d="M2250 3335 l0 -245 360 0 360 0 0 245 0 245 -360 0 -360 0 0 -245z m340 115 l0 -100 -155 0 -155 0 0 100 0 100 155 0 155 0 0 -100z m350 0 l0 -100 -160 0 -160 0 0 100 0 100 160 0 160 0 0 -100z m-350 -230 l0 -100 -155 0 -155 0 0 100 0 100 155 0 155 0 0 -100z m350 0 l0 -100 -160 0 -160 0 0 100 0 100 160 0 160 0 0 -100z"></path>
            <path
                d="M2370 2250 l0 -360 245 0 245 0 0 360 0 360 -245 0 -245 0 0 -360z m230 175 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z"></path>
            <path
                d="M4560 1765 l0 -875 130 0 130 0 0 875 0 875 -130 0 -130 0 0 -875z m230 690 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -340 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -340 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -345 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m0 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z"></path>
            <path
                d="M5460 1755 l0 -885 245 0 245 0 0 885 0 885 -245 0 -245 0 0 -885z m230 700 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z"></path>
            <path d="M7550 1865 l0 -375 30 0 30 0 0 375 0 375 -30 0 -30 0 0 -375z"></path>
        </g>

        <!--SVG coordinates for 'Room 1'-->
        <a href="#" fill="white" id="room_1" class="room" onclick="handlePopup('room_1', 'Room 1')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)">
                <path stroke-width="5" stroke="#557731"
                      d="M440 3365 l0 -815 700 0 700 0 0 815 0 815 -700 0 -700 0 0 -815z"></path>
            </g>
        </a>

        <!--SVG coordinates for 'Room 2'-->
        <a fill="white" href="#" id="room_2" onclick="handlePopup('room_2', 'Room 2')">
            <g stroke="none" transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)">
                <path
                    d="M440 1615 l0 -904 33 -5 c30 -4 1213 -37 1320 -36 l47 0 0 925 0 925 -700 0 -700 0 0 -905z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="room_3" onclick="handlePopup('room_3', 'Room 3')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M4910 3855 l0 -575 780 0 780 0 0 575 0 575 -780 0 -780 0 0 -575z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="room_4" onclick="handlePopup('room_4', 'Room 4')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M6530 3855 l0 -575 234 0 233 0 207 210 206 211 0 364 0 365 -440 0
-440 0 0 -575z"></path>
            </g>
        </a>


        <a fill="white" href="#" id="desk_1" onclick="handlePopup('desk_1', 'Desk 1')">
            <g stroke="none" transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)">
                <path d="M2280 3450 l0 -100 155 0 155 0 0 100 0 100 -155 0 -155 0 0 -100z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_2" onclick="handlePopup('desk_2', 'Desk 2')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2620 3450 l0 -100 160 0 160 0 0 100 0 100 -160 0 -160 0 0 -100z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_3" onclick="handlePopup('desk_3', 'Desk 3')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2280 3220 l0 -100 155 0 155 0 0 100 0 100 -155 0 -155 0 0 -100z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_4" onclick="handlePopup('desk_4', 'Desk 4')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2620 3220 l0 -100 160 0 160 0 0 100 0 100 -160 0 -160 0 0 -100z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_5" onclick="handlePopup('desk_5', 'Desk 5')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2400 2425 l0 -155 100 0 100 0 0 155 0 155 -100 0 -100 0 0 -155z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_6" onclick="handlePopup('desk_6', 'Desk 6')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2630 2425 l0 -155 100 0 100 0 0 155 0 155 -100 0 -100 0 0 -155z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_7" onclick="handlePopup('desk_7', 'Desk 7')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2400 2080 l0 -160 100 0 100 0 0 160 0 160 -100 0 -100 0 0 -160z"></path>
            </g>
        </a>

        <a fill="white" href="#" id="desk_8" onclick="handlePopup('desk_8', 'Desk 8')">
            <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M2630 2080 l0 -160 100 0 100 0 0 160 0 160 -100 0 -100 0 0 -160z"></path>
            </g>
        </a>

    </svg>
</div>
</body>
</html>