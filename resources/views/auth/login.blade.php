@extends('layouts.app')

@section('content')
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
@endsection
