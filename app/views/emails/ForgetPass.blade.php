<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<div style=" border: 1px solid #166ead;margin: 0 auto;min-height: 100%;width: 100%; display:inline-block; background:#166ead">
   			<div style="height: 50px;margin: 0 auto;width: 100%; margin-bottom: 2px; display: inline-block; color: #fff;">
  				 <div style="float: left;margin: 0 auto;width: 25%;">
			        <div style="padding-top: 10px;padding-left: 15px;">
			           <a href="{{URL::route('site.home')}}"><img style="margin-top:5px; max-height: 30px; height:30px" id="logo" src="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/logo.png" /></a>
				    </div>
				 </div>
    			<div style="display:inline-block;float:right;color:#fff; line-height:50px;padding-right:20px; font-style: italic;">{{CGlobal::phoneSupport}}</div>
	    	</div>
	    	<div style="background: #fff;margin: 0 auto;min-height: 200px;padding: 3% 2%;width: 88%;">
				<b>Thay đổi mật khẩu tại {{CGlobal::web_name}}</b><br/>
				Chào: {{ucwords($data['customer_name'])}}<br/>
				Dưới đây là thông tin đăng nhập<br/><br/>
				<b>Tên đăng nhập:</b> {{$data['customer_email']}}<br/>
				<b>Mật khẩu:</b> {{$data['customer_password']}}<br/><br/>
				Ghi chú: Bạn hay đăng nhập và thay đổi mật khẩu cho bảo mật lần đăng nhập sau.
	    	</div>
	  		<div style="max-height: 34px; height:34px; width: 100%;">
		        <div style="margin: 0 auto;width: 100%;">
		            <span style="color:#fff; padding-right: 15px;float: right; padding-top: 10px;">&copy; <a style="text-decoration: none; color:#fff;" href="{{URL::route('site.home')}}">{{ucwords(CGlobal::web_name)}}</a>, 2015-{{date('Y', time())}}.</span>
		        </div>
    		</div>
	  	</div>
	</body>
</html>
