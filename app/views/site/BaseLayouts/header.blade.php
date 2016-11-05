<div class="line-head">
	<div class="container">
		@if(Route::currentRouteName() == 'site.index')
      		<h1 class="logo">
      			<a href="{{URL::route('site.home')}}"><img src="{{URL::route('site.home')}}/assets/frontend/img/logo.png" alt="{{CGlobal::web_name}}"></a>
      		</h1>
      		@else
      		<div class="logo">
      			<a href="{{URL::route('site.home')}}"><img src="{{URL::route('site.home')}}/assets/frontend/img/logo.png" alt="{{CGlobal::web_name}}"></a>
      		</div>
      	@endif
		<div class="like-social">
			<div class="fb">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-like" data-href="http://shopcuatui.com.vn"
					data-layout="button_count" data-action="like" 
					data-show-faces="false" data-share="false">
				</div>
			</div>
			<div class="gg">
	            <script src="https://apis.google.com/js/platform.js" async defer></script>
	            <g:plus action="share" annotation="bubble"></g:plus>
	            <div class="g-plusone" data-size="medium"></div>
	        </div>
		</div>
		<div class="box-search">
			<form class="seach" action="" method="get">
				<input name="q" class="keyword" placeholder="Tìm kiếm..." type="text">
				<input value="Search" class="btn-seach" type="submit">
			</form>
		</div>
		<div class="btn-post-text">
			<a href="">Đăng tin</a>
		</div>
		<ul class="list-link">
			<li>
				<a href="javascript:void(0);"><i class="fa fa-lock"></i>Đăng nhập</a>
			</li>
		</ul>
	</div>
</div>
<div class="line-ads">
	<div class="container">
		<img src="http://static.eclick.vn/uploads/source/2016/11/04/e8243811134957616h825452811.jpeg" width="980">
	</div>
</div>