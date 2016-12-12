<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>i-NQ - Dashboard</title>

    <link href="dashboard/website/webpages/css/bootstrap.min.css" rel="stylesheet">
    <link href="dashboard/website/webpages/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="dashboard/website/webpages/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="dashboard/website/webpages/js/html5shiv.min.js"></script>
    <script src="dashboard/website/webpages/js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>i-NQ</span>Admin</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <svg class="glyph stroked male-user">
                            <use href="#stroked-male-user"></use>
                        </svg>
                        <span id="user"></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="logout.php">
                            <svg class="glyph stroked cancel">
                                <use href="#stroked-cancel"></use>
                            </svg>
                            Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <ul class="nav menu">
        <li class="active"><a href="index.html">
            <svg class="glyph stroked dashboard-dial">
                <use xlink:href="#stroked-dashboard-dial"></use>
            </svg>
            Dashboard</a></li>
        <li><a href="booking-system/application.php" target="_blank">
            <svg class="glyph stroked calendar">
                <use xlink:href="#stroked-calendar"></use>
            </svg>
            Book Now</a></li>
        <li><a href="#">
            <svg class="glyph stroked plus sign">
                <use xlink:href="#stroked-plus-sign"/>
            </svg>
            Buy More Time</a></li>
        <li role="presentation" class="divider"></li>
        <li><a href="dashboard/website/webpages/login.html">
            <svg class="glyph stroked male-user">
                <use xlink:href="#stroked-male-user"></use>
            </svg>
            Login Page</a></li>
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                <svg class="glyph stroked home">
                    <use xlink:href="#stroked-home"></use>
                </svg>
            </a></li>
            <li class="active">Icons</li>
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked clock">
                            <use xlink:href="#stroked-clock"></use>
                        </svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><span id="num_desk_hours"></span></div>
                        <div class="text-muted">Hours</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked calendar">
                            <use xlink:href="#stroked-calendar"></use>
                        </svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><span id="num_days"></span></div>
                        <div class="text-muted">Days</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <svg class="glyph stroked male-user">
                            <use xlink:href="#stroked-male-user"></use>
                        </svg>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><span id="num_room_hours"></span></div>
                        <div class="text-muted">Meetings</div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default chat">
                <div class="panel-heading" id="accordion">
                    On@iNQ
                </div>
                <div class="panel-body">
                    <ul>
                        <li class="left clearfix">
								<span class="chat-img pull-left">
									<img src="http://placehold.it/80/30a5ff/fff" alt="User Avatar" class="img-circle"/>
								</span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">John Doe</strong>
                                    <small class="text-muted">32 mins ago</small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ante turpis, rutrum
                                    ut ullamcorper sed, dapibus ac nunc. Vivamus luctus convallis mauris, eu gravida
                                    tortor aliquam ultricies.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-md"
                               placeholder="Type your message here..."/>
                        <span class="input-group-btn">
								<button class="btn btn-success btn-md" id="btn-chat">Send</button>
							</span>
                    </div>
                </div>
            </div>

        </div><!--/.col-->

        <div class="col-md-4">

            <div class="panel panel-blue">
                <div class="panel-heading dark-overlay">
                    Current Bookings
                </div>
                <div id="bookings" class="panel-body">
                </div>
            </div>
        </div><!--/.col-->
    </div><!--/.row-->
</div>    <!--/.main-->

<script src="dashboard/website/webpages/js/jquery-1.11.1.min.js"></script>
<script src="dashboard/website/webpages/js/bootstrap.min.js"></script>
<script src="booking-system/js/moment.js"></script>
<script src="booking-system/js/populateUserInfo.js"></script>
</body>

</html>
