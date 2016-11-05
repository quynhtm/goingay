<!DOCTYPE html>
<html lang="en">
<head>
	<title>@if(isset($title)) {{$title}} @else ADMIN @endif</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	{{ HTML::style('assets/libs/bootstrap/css/bootstrap.css'); }}
    {{ HTML::style('assets/focus/css/reset.css'); }}
    {{ HTML::style('assets/backend/css/admin.css'); }}
    {{ HTML::style('assets/backend/css/media.css'); }}
    {{ HTML::style('assets/libs/fontAwesome/4.2.0/css/font-awesome.min.css'); }}
    
    {{ HTML::script('assets/focus/js/jquery.2.1.1.min.js', array(), Config::get('config.SECURE')) }}
	{{ HTML::script('assets/libs/bootstrap/js/bootstrap.min.js', array(), Config::get('config.SECURE')) }}
    
	<script type="text/javascript">
		var WEB_ROOT = "{{ URL::to('/')}}";
	</script>
    {{CGlobal::$extraHeaderCSS}}
    {{CGlobal::$extraHeaderJS}}
	
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