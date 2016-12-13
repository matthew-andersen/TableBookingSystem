//javascript for the booking popup interface
//alert("test");
var popup = document.getElementById("dialog")
var toOpen = document.getElementById("opener")

// Function to popup the booking window
  $( function() {
    	$( popup ).dialog({    //This dialog fuction doesn't work at first, due to the wrong order of the paths.
    	autoOpen: false, });
      $( toOpen ).on( "click", function() {
     $( popup ).dialog( "open" );  
     //$(toOpen).hide(); //Used for testing.
  } );
  });