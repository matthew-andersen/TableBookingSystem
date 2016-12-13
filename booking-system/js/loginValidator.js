/**
 * Created by Draga on 13/12/2016.
 */
loginRequest = new XMLHttpRequest();
loginRequest.onload =
    function () {
        alert(this.responseText);
    };

loginRequest.open("GET", "../../dashboard/website/webpages/index.php");
loginRequest.send();