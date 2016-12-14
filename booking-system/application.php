<!--TODO: The rooms/desks need to be properly identified to avoid later confusion-->
<?php
session_start();

if (!isset($_SESSION['current_userid']) || empty($_SESSION['current_userid'])) {
    header("Location: ../index.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking System</title>
    <script src="js/moment.js"></script>
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
        </div>
    </div>
    <div id="review-box">
        <div id="cart-box">
            <div id="cart-box-header">Your Cart</div>
            <div id="cart-box-order"></div>
        </div>
        <button id="submit-button" onclick="submitOrder()">Buy Now</button>
        <button id="clear-button" onclick="clearOrder()">Clear Cart</button>
    </div>
</div>

<div id="right-col">
    <div id="date-nav-box">
        <a href="#">
            <div id="day-nav-arrow-left" onclick="changeDate('dayBack')"></div>
        </a>
        <a href="#">
            <div id="hour-nav-arrow-left" onclick="changeDate('hourBack')"></div>
        </a>
        <a>
            <div id="date-display-box"></div>
        </a>
        <a href="#">
            <div id="day-nav-arrow-right" onclick="changeDate('dayForward')"></div>
        </a>
        <a href="#">
            <div id="hour-nav-arrow-right" onclick="changeDate('hourForward')"></div>
        </a>
    </div>


    <div id="dialog" hidden>
    </div>

    <svg height="698pt" preserveaspectratio="xMidYMid meet" version="1.0" viewbox="0 0 971 698"
         xmlns="http://www.w3.org/2000/svg">

        <!--SVG coordinates for map outline. Make sure to overwrite this if changing the floor plan.-->
        <g transform="translate(0.000000,698.000000) scale(0.100000,-0.100000)"
           fill="#000000" stroke="none">
            <path d="M4863 6585 c-10 -11 -13 -363 -13 -1690 l0 -1675 660 0 660 0 0 30 0
                30 -630 0 -630 0 0 575 0 575 780 0 780 0 0 -585 0 -585 30 0 30 0 0 585 0
                585 440 0 440 0 0 -365 0 -364 -206 -211 -207 -210 -83 0 -84 0 0 -30 0 -30
                93 0 92 0 228 228 227 227 0 1118 0 1117 565 0 565 0 0 30 0 30 -950 0 -950 0
                0 65 0 65 -30 0 -30 0 0 -805 0 -805 -380 0 -380 0 0 1025 0 1025 380 0 380 0
                0 -40 c0 -38 2 -40 30 -40 l30 0 0 70 0 70 -485 0 -485 0 0 -30 c0 -29 2 -30
                45 -30 l45 0 0 -1025 0 -1025 -455 0 -455 0 0 1025 0 1025 225 0 225 0 0 30 0
                30 -242 0 c-197 -1 -245 -3 -255 -15z m2547 -1385 l0 -710 -355 0 -355 0 0
                710 0 710 355 0 355 0 0 -710z">
            </path>
            <path d="M8880 5940 l0 -30 63 0 62 0 108 -108 107 -107 0 -283 0 -282 -348 0
                -348 0 -54 -97 c-29 -54 -60 -108 -67 -119 -12 -19 -11 -23 11 -37 l25 -17 58
                105 58 105 333 0 332 0 0 -710 0 -710 -545 0 -545 0 0 280 0 280 77 191 c72
                182 75 193 58 205 -10 8 -22 14 -25 14 -4 0 -43 -92 -88 -205 l-82 -206 0
                -374 0 -375 30 0 30 0 0 65 0 65 545 0 545 0 0 -490 0 -490 -545 0 -545 0 0
                285 0 285 -30 0 -30 0 0 -285 0 -285 -260 0 -260 0 0 -45 c0 -43 1 -45 30 -45
                20 0 30 5 30 15 0 13 96 15 805 15 l805 0 0 -1045 0 -1045 -97 0 c-54 0 -388
                9 -743 20 -355 11 -673 20 -707 20 l-63 0 0 345 0 345 -30 0 -30 0 0 -342 0
                -341 -250 6 -250 7 0 -29 0 -29 173 -6 c337 -13 2049 -57 2053 -53 2 2 4 1200
                4 2663 l0 2659 -122 122 -123 123 -77 0 -78 0 0 -30z">
            </path>
            <path d="M380 3150 c0 -2384 1 -2510 18 -2510 9 0 1340 -36 2957 -80 1617 -44
                2970 -80 3008 -80 l67 0 0 30 0 30 -68 0 c-37 0 -1057 27 -2267 60 -1210 33
                -2206 60 -2212 60 -10 0 -13 97 -13 450 l0 450 1088 0 c833 0 1091 3 1100 12
                9 9 12 317 12 1325 l0 1313 -195 0 c-167 0 -195 2 -195 15 0 13 -187 15 -1620
                15 l-1620 0 0 680 0 680 1975 0 1975 0 0 30 0 30 -2005 0 -2005 0 0 -2510z
                m1460 215 l0 -815 -700 0 -700 0 0 815 0 815 700 0 700 0 0 -815z m2200 -480
                l0 -1295 -1085 0 -1085 0 0 1295 0 1295 1085 0 1085 0 0 -1295z m-2200 -1296
                l0 -930 -152 6 c-164 6 -1148 35 -1210 35 l-38 0 0 910 0 910 700 0 700 0 0
                -931z">
            </path>
            <path d="M3450 3245 l0 -535 245 0 245 0 0 535 0 535 -245 0 -245 0 0 -535z
                m230 350 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0
                -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100
                0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160
                0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100
                0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z">
            </path>
            <path d="M2250 3335 l0 -245 360 0 360 0 0 245 0 245 -360 0 -360 0 0 -245z
                m340 115 l0 -100 -155 0 -155 0 0 100 0 100 155 0 155 0 0 -100z m350 0 l0
                -100 -160 0 -160 0 0 100 0 100 160 0 160 0 0 -100z m-350 -230 l0 -100 -155
                0 -155 0 0 100 0 100 155 0 155 0 0 -100z m350 0 l0 -100 -160 0 -160 0 0 100
                0 100 160 0 160 0 0 -100z">
            </path>
            <path d="M2370 2250 l0 -360 245 0 245 0 0 360 0 360 -245 0 -245 0 0 -360z
                m230 175 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0
                -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100
                0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160
                0 160 100 0 100 0 0 -160z">
            </path>
            <path d="M4560 1765 l0 -875 130 0 130 0 0 875 0 875 -130 0 -130 0 0 -875z
                m230 690 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -340 l0
                -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -340 l0 -155 -100 0
                -100 0 0 155 0 155 100 0 100 0 0 -155z m0 -345 l0 -160 -100 0 -100 0 0 160
                0 160 100 0 100 0 0 -160z m0 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0
                100 0 0 -160z">
            </path>
            <path d="M5460 1755 l0 -885 245 0 245 0 0 885 0 885 -245 0 -245 0 0 -885z
                m230 700 l0 -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m230 0 l0
                -155 -100 0 -100 0 0 155 0 155 100 0 100 0 0 -155z m-230 -345 l0 -160 -100
                0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160
                0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100
                0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z
                m-230 -350 l0 -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0
                -160 -100 0 -100 0 0 160 0 160 100 0 100 0 0 -160z m-230 -350 l0 -160 -100
                0 -100 0 0 160 0 160 100 0 100 0 0 -160z m230 0 l0 -160 -100 0 -100 0 0 160
                0 160 100 0 100 0 0 -160z">
            </path>
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