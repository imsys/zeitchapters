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
                        <a href="{{ URL::to('fblogin') }}" class="btn btn-primary mws-login-button" style="width: 90%;" >Acesse usando o Facebook</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop