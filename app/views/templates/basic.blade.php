<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Apple iOS and Android stuff (do not remove) -->
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1" />

<!-- Required Stylesheets -->
{{ HTML::style('css/reset.css') }}
{{ HTML::style('css/text.css') }}
{{ HTML::style('css/fonts/ptsans/stylesheet.css') }}

{{ HTML::style('css/core/form.css') }}
{{ HTML::style('css/core/login.css') }}
{{ HTML::style('css/core/button.css') }}
{{ HTML::style('css/mws.theme.css') }}

<!-- JavaScript Plugins -->
{{ HTML::script('js/jquery-1.7.2.min.js') }}
{{ HTML::script('js/jquery.placeholder.js') }}

<!-- jQuery-UI Dependent Scripts -->
{{ HTML::script('jui/js/jquery-ui-effecs.min.js') }}

<!-- Plugin Scripts -->
{{ HTML::script('plugins/validate/jquery.validate-min.js') }}

<!-- Login Script -->
{{ HTML::script('js/core/login.js') }}

<title>Zeitgeist - Chapters ADM</title>

</head>

<body>

    @yield('content')

</body>
</html>