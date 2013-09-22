<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Plugin Stylesheets first to ease overrides -->
{{ HTML::style('plugins/ibutton/jquery.ibutton.css') }}

<!-- Required Stylesheets -->
{{ HTML::style('bootstrap/css/bootstrap.min.css') }}
{{ HTML::style('css/fonts/ptsans/stylesheet.css') }}
{{ HTML::style('css/fonts/icomoon/style.css') }}

{{ HTML::style('css/mws-style.css') }}
{{ HTML::style('css/icons/icol16.css') }}
{{ HTML::style('css/icons/icol32.css') }}

<!-- Demo Stylesheet -->
{{ HTML::style('css/demo.css') }}

<!-- jQuery-UI Stylesheet -->
{{ HTML::style('jui/css/jquery.ui.all.css') }}
{{ HTML::style('jui/jquery-ui.custom.css') }}

<!-- Theme Stylesheet -->
{{ HTML::style('css/mws-theme.css') }}
{{ HTML::style('css/themer.css') }}

<style>
	div.ibutton-label-off {
		color: #838383;
		background-color: #CECECE;
		border: 1px solid #949494;
	}
	a {color:black;}
</style>


@yield('styles')

<title>Zeitgeist - Chapters ADM</title>

</head>

<body>
@section('body')


	<!-- Header -->
	<div id="mws-header" class="clearfix">

    	<!-- Logo Container -->
    	<div id="mws-logo-container">

        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        	<div id="mws-logo-wrap">
            	<a href="{{ URL::to('/') }}"><img src="{{ URL::asset('images/tzmau-logo.png') }}" /></a>
			</div>
        </div>

        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">



            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">

            	<!-- User Photo -->
            	<div id="mws-user-photo" style="background: #E7E7E7;">
                	<img src="{{ URL::asset('css/icons/icol32/user_suit.png') }}" />
                </div>

                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
						@if (Auth::check())
                        {{ trans('general.welcome', array('name' => current(array_slice(explode(" ", Auth::user()->name), 0,1)) )) }}
						@endif
					</div>

                    <ul>
                    	<li><a href="{{ URL::to('chapter/view/1') }}">Home</a></li>
                       {{-- <li><a href="{-{ URL::to('profile/changepassword') }-}">{-{ trans('general.changepwd') }-}</a></li> --}}
                        <li><a href="{{ URL::to('logout') }}">{{ trans('general.logout') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">

    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>

        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
			@include('templates.menu')
        </div>

        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">

        	<!-- Inner Container Start -->
            <div class="container">

				@yield('content')

            </div>
            <!-- Inner Container End -->

            <!-- Footer -->
            <div id="mws-footer">
            	Copyright &copy; {{ date('Y') }} by The Zeitgeist Movement.
            </div>

        </div>
        <!-- Main Container End -->

    </div>



	
@show


    <!-- JavaScript Plugins -->
	{{ HTML::script('js/libs/jquery-1.8.3.min.js') }}
	{{ HTML::script('js/libs/jquery.mousewheel.min.js') }}
	{{ HTML::script('js/libs/jquery.placeholder.min.js') }}
	{{ HTML::script('custom-plugins/fileinput.js') }}

    <!-- jQuery-UI Dependent Scripts -->
	{{ HTML::script('jui/js/jquery-ui-1.9.2.min.js') }}
	{{ HTML::script('jui/jquery-ui.custom.min.js') }}
	{{ HTML::script('jui/js/jquery.ui.touch-punch.js') }}

    <!-- Plugin Scripts -->
	{{ HTML::script('plugins/ibutton/jquery.ibutton.min.js') }}

    <!-- Core Script -->
	{{ HTML::script('bootstrap/js/bootstrap.min.js') }}
	{{ HTML::script('js/core/mws.js') }}

    <!-- Scripts -->
	@yield('scripts')

</body>
</html>