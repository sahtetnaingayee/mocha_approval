<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="{!!asset('css/style.css')!!}">

       
    </head>
    <body>
        <section class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <a href=""><img src="{!!asset('img/logo.png')!!}" class="logo"></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="body-panel">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <img src="{!!asset('img/dashboard.png')!!}" class="img-responsive img-block">
                    </div>

                    <div class="col-md-4">
                        <form class="form-horizontal login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            
                        </div>

                        <div class="form-group">
                            
                                <div class="checkbox pt10 inline-block">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                    
                                </div>

                                <button type="submit" class="btn btn-login pull-right">
                                    Login
                                </button>

                           
                        </div>

                        <div class="form-group">

                            <a class="btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                            
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>

    </body>
</html>
