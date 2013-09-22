@extends('templates.main')
@section('styles')
{{ HTML::style('css/login.css') }}
@stop

@section('body')
<div id="mws-login-wrapper">
        <div id="mws-login">
            <h1>{{ trans('login.logintitle') }}</h1>
            <div class="mws-login-lock"><i class="icon-lock"></i></div>
            <div id="mws-login-form">
                <form class="mws-form" action="{{ URL::to('login') }}" method="post">
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="text" name="email" class="mws-login-username required" placeholder="{{ trans('login.email_placeholder') }}">
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <div class="mws-form-item">
                            <input type="password" name="password" class="mws-login-password required" placeholder="{{ trans('login.pwd_placeholder') }}">
                        </div>
                    </div>
                  <!--  <div id="mws-login-remember" class="mws-form-row mws-inset">
                        <ul class="mws-form-list inline">
                            <li>
                                <input id="remember" type="checkbox">
                                <label for="remember">{{ trans('login.rememberme') }}</label>
                            </li>
                        </ul>
                    </div> -->
                    <div class="mws-form-row">
                        <input type="submit" value="{{ trans('login.login_btn') }}" class="btn btn-success mws-login-button">
                    </div>
				  <div class="mws-form-row" style="text-align: center;color:white; padding: 0;">
					  <span>ou</span>
                    </div>
				  <div class="mws-form-row">
                        <a href="{{ URL::to('fblogin') }}" class="btn btn-primary mws-login-button" style="width: 90%;" >Logar-se usando o Facebook</a>
                    </div>
                </form>
            </div>
        </div>
	{{ HTML::link('registration','Registre-se pelo Facebook') }}
    </div>
@stop