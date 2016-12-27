<!DOCTYPE html>
<html lang="vi">
<head>
	{{CGlobal::$extraMeta}}
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/favicon.ico" type="image/vnd.microsoft.icon">
		
	{{ HTML::style('assets/lib/bootstrap/css/bootstrap.css'); }}
	{{ HTML::style('assets/frontend/css/site.css'); }}
	{{ HTML::style('assets/frontend/css/media.css'); }}
	
	{{ HTML::script('assets/js/jquery.2.1.1.min.js', array(), Config::get('config.SECURE')) }}
	{{ HTML::script('assets/lib/bootstrap/js/bootstrap.min.js', array(), Config::get('config.SECURE')) }}
	 
	{{CGlobal::$extraHeaderCSS}}
	{{CGlobal::$extraHeaderJS}}
	
    <script type="text/javascript">
        var WEB_ROOT = "{{url('', array(), Config::get('config.SECURE'))}}";
        var DEVMODE = "{{Config::get('config.DEVMODE')}}";
        var COOKIE_DOMAIN = "{{Config::get('config.DOMAIN_COOKIE_SERVER')}}";
    </script>
    
    @if(Config::get('config.DEVMODE') == false)
        <meta name="google-site-verification" content="ym-Qp_UzWfK9_x0s833yXAvH53dqYde6N4KxlImiiMs" />
        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-89456953-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
    @endif
</head>
<body>
<div id="wrapper">
	@if(isset($header))
	<div id="header">
		{{$header}}
	</div>
	@endif
	 
	<div id="content">
		<div class="line-content">
			<div class="container">
				@if(isset($menuLeft))
					{{$menuLeft}}
				@endif
				
				@if(isset($content))
					{{$content}}
				@endif
			</div>
		</div>
	</div>
	
	@if(isset($footer))
	<div id="footer">
		{{$footer}}
	</div>
	@endif
	@if(isset($popupHide))
		{{$popupHide}}
     @endif
</div>
{{CGlobal::$extraFooterCSS}}
{{CGlobal::$extraFooterJS}}
</body>
</html>
