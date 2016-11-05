<!DOCTYPE html>
<html lang="en">
<head>
	{{CGlobal::$extraMeta}}
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/favicon.ico" type="image/vnd.microsoft.icon">

    {{ HTML::style('assets/frontend/css/site.css?ver='.CGlobal::$css_ver, array(), Config::get('config.SECURE')) }}
	{{CGlobal::$extraHeaderCSS}}
    <script type="text/javascript">
        var WEB_ROOT = "{{url('', array(), Config::get('config.SECURE'))}}";
        var DEVMODE = "{{Config::get('config.DEVMODE')}}";
        var COOKIE_DOMAIN = "{{Config::get('config.DOMAIN_COOKIE_SERVER')}}";
    </script>
    {{ HTML::script('assets/js/jquery.2.1.1.min.js', array(), Config::get('config.SECURE')) }}
    {{CGlobal::$extraHeaderJS}}
    @if(Config::get('config.DEVMODE') == false)
        
    @endif
</head>
<body>
<div id="wrapper">
	@if(isset($header))
	<div id="header">
		{{$header}}
	</div>
	@endif
	 @if(isset($content))
	<div id="content">
		{{$content}}
	</div>
	@endif
	@if(isset($footer))
	<div id="footer">
		{{$footer}}
	</div>
	@endif
</div>
{{CGlobal::$extraFooterCSS}}
{{CGlobal::$extraFooterJS}}
</body>
</html>
