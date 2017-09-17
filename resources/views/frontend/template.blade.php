<!DOCTYPE html>
<html>
<head>
	<title>Mocal App</title>

	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="{!!asset('plugins/bootstrap/css/bootstrap.min.css')!!}">

    
    <link href="{!!asset('plugins/mmenu/mmenu.css')!!}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="{!!asset('plugins/bootstrap/js/bootstrap.min.js')!!}"></script>

    <script type="text/javascript" src="{!!asset('plugins/mmenu/mmenu.js')!!}"></script>
    
    <script type="text/javascript">
    	
    	$(function() {
			$('nav#menu').mmenu({
            	
			});

		});
    </script>

    <link href="{!!asset('css/frontend.css')!!}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{!!asset('js/frontend.js')!!}"></script>


</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 p0">
				<nav id="menu">

					<ul>
						<li class="menu_panel">
							<img src="{!!asset('img/m-logo.png')!!}" class="img-logo">
						</li>
						<li style="min-height:600px;">
							<div id="calendar" class="has-toolbar"> </div>
						</li>
					</ul>
				</nav>

				<div id="page">
					<div id="header">
						<a href="#menu"></a>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	@yield('content')

	<div class="f_action">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<ul class="f_menu">
						<li>
							<a href="">
								<img src="{!!asset('img/icon/f-1.png')!!}" class="img-block">
								<h4>Calendar</h4>
							</a>
						</li>
						<li>
							<a href="">
								<img src="{!!asset('img/icon/f-2.png')!!}" class="img-block">
								<h4>Approval</h4>
							</a>
						</li>
						<li>
							<a href="">
								<img src="{!!asset('img/icon/f-3.png')!!}" class="img-block">
								<h4>Scheduled</h4>
							</a>
						</li>

					</ul>
				</div>
			</div>
		</div>
	</div>

	<link rel="stylesheet" type="text/css" href="{!!asset('/plugins/jquery-ui/jquery-ui.min.css')!!}">
	<script src="{!!asset('/plugins/jquery-ui/jquery-ui.min.js')!!}" type="text/javascript"></script>
    

	<script src="{!!asset('/plugins/moment.min.js')!!}" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="{!!asset('/plugins/fullcalendar/fullcalendar.min.css')!!}">
    <script src="{!!asset('/plugins/fullcalendar/fullcalendar.min.js')!!}" type="text/javascript"></script>

    <script src="{!!asset('js/calendar.js')!!}" type="text/javascript"></script>

    <script type="text/javascript">
    
    		var $url='{!!url("postcount/20/20")!!}';
            AppCalendar.init($url); 

    </script>

</body>
</html>