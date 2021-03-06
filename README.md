# Table Booking System

An interactive booking system that allows a user to make bookings for a certain duration.

## Features

- New users can register with a username and password, and receive a initial allotment of time (10 desk hours and 4 meeting room hours)
- Users can log in and out from the dashboard, and remain logged in when travelling to the booking system from the dashboard
- The user’s dashboard contains their time allotments
- The user’s dashboard contains a booking itinerary based on confirmed bookings in the database
- A booking system which is updated from database records with each date change and shows live availabilities for each desk/room
- Ability for the user to make bookings, these records are stored in a database
- User is alerted and disallowed from making bookings which would conflict with already existing records
- User is alerted and disallowed if they try to book more than their allocated time
- Instructions on how to edit/add further locations are included in the 'Modifying Map' section

## Getting Started

These instructions will get the project up and running on your machine for development and usage purposes. See deployment for notes on how to deploy the project on a live system.

## Deployment

### Prerequisites

A MySQL database with appropriate structuring and records will be needed for the software to function. Samples can be found in the 'db-assets' folder. Furthermore, a server will be needed to host the PHP files. For development purposes WAMP has been used so far.

For local testing purposes, the developers used an installation of the following WAMP bundle (instructions for Windows).
1. Download and install the appropriate version of the software for your system architecture, ensuring to install it directly into C: drive (not in any subfolders).
2. Create a database by clicking the icon in your taskbar and following the link to phpMyAdmin
3. Import the two SQL tables provided in the db-assets folder
4. Change the details in the php files to details of your newly created database
5. Place your website directories in a newly created directory at C:\wamp64\www , titled tablebookingsystem
6. View your website by following the link to localhost in WAMP and clicking tablebookingsystem under "My Projects"

### Modifying Map
The map is based on SVG components, made clickable with anchor tags.

1. A base outline template of the floor plan will need to be saved as an SVG and then the vector code must be added into the application.php (in the 'booking-system folder'). Make sure to replace the current one
2. Too add rooms/desks/locations coloured blocks need to be overlayed on the template then these blocks need to be saved as SVGs
3. The SVG vector codes will then need to be copied into the index.php below the previously added base layout template
4. To make the rooms/desks/locations interactive, the vector code will need to be wrapped in an `<a>` tag. The template for this is as follows (be sure to replace the caps lock text with the appropriately described info):

    `<a href="#" fill="white" id="UNIQUE ID OF THE LOCATION (e.g. room_1)" onclick="handleLocationSelection('UNIQUE ID OF THE LOCATION E.G. room_1', 'DESCRIPTION OF THE LOCATION E.G. Room 1')">`
5. Finally, in the script.js add the location id in the roomList array variable. For example:
    
    `var roomList = ['desk_1', 'room_1']`

## Built With

* [Lumino](http://medialoot.com/item/lumino-admin-bootstrap-template/) - Bootstrap dashboard template
* [Moment.js](http://momentjs.com/) - Handling date and time

## Authors

Contributors to this repository are as follows:

* **[Matthew Andersen](https://github.com/matthew-andersen)** - *Interactive application*
* **[Donald Cull](https://github.com/donaldCull)** - *User dashboard interface*
* **[Draga Doncila](https://github.com/DragaDoncila)** - *Interactive application*

## License

This work is copyrighted by the authors. Reuse or modification is strictly prohibited without expressed permission from the authors.
