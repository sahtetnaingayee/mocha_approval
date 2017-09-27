<!DOCTYPE html>
<html>
<head>
	<title>Mocha App Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{!!asset('plugins/bootstrap/css/bootstrap.min.css')!!}">
	<link href="{!!asset('css/frontend.css')!!}" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="card card-container">
		            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
		            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
		            <p id="profile-name" class="profile-name-card"></p>
		             {!! Form::open(array('url' =>'client-login','class'=>'form-signin','files'=>true,'method'=>'post')) !!}
		            
		                <span id="reauth-email" class="reauth-email"></span>
		                <input type="email" name="email" id="inputPassword" class="form-control" placeholder="Email" required>
		                 <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		               
		                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
		            {!!Form::close()!!}
		            
		        </div>
			</div>
		</div>
	</div>
</body>
</html>