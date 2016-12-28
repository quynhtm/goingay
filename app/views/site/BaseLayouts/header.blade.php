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
		<div class="like-social" style="display: none">
			<div class="fb">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.6";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-like" data-href="{{CGlobal::web_name}}"
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
			<form class="seach" action="{{URL::route('site.searchItems')}}" method="get">
				<input id="sys_keyword" name="keyword" class="keyword" placeholder="Nhập tiêu đề tin cần tìm" type="text" value="{{$keyword}}">
				<input value="{{$category_id}}" name="category_id" id="category_id_search" type="hidden">
				<input value="{{$province_id}}" name="city_id" id="city_id_search" type="hidden">
				<input value="Search" class="btn-seach" type="submit">
			</form>
		</div>
		{{--<div class="box-provice">
			<i class="icon-address"></i>
			<div class="panel-list-provice" style="display: none">
				<ul>
					<li><a href="" title="">Hà Nội</a></li>
					<li><a href="" title="">Hồ Chí Minh</a></li>
					<li><a href="" title="">Đà Nẵng</a></li>
					<li><a href="" title="">Nha Trang</a></li>
					<li><a href="" title="">Bình Dương</a></li>
					<li><a href="" title="">Buôn Ma Thuột</a></li>
				</ul>
			</div>
		</div>--}}
		<div class="btn-post-text">
			<?php 
				$link = 'javascript:void(0)';
				$class = 'class="aRegPost"';
				if(isset($user_customer['customer_id']) && $user_customer['customer_id'] > 0){
					$link = URL::route('customer.ItemsAdd');
					$class = '';
				}
			?>
			<a {{$class}} href="{{$link}}">Đăng tin</a>
		</div>
		@if(empty($user_customer))
		<ul class="list-link">
			<li class="clickLogin">
				<a href="javascript:void(0);"><i class="fa fa-lock"></i>Đăng nhập</a>
			</li>
			<li class="clickRegister">
				<a href="javascript:void(0);"><i class="fa fa-plus"></i>Đăng ký</a>
			</li>
		</ul>
		@else
		<div class="box-login">
			<div class="cpanel-page">
				<a href="javascript:void(0)" class="name-customer">Chào: {{isset($user_customer['customer_name']) ? $user_customer['customer_name'] : 'No Name'}}</a>
				<ul class="list-cpanel">
					<li><a href="{{URL::route('customer.pageChageInfo')}}" rel="nofollow"><i class="glyphicon glyphicon-align-left"></i> Thông tin cá nhân</a></li>
					<li><a href="{{URL::route('customer.ItemsList')}}" rel="nofollow"><i class="glyphicon glyphicon-equalizer"></i> Danh sách tin đăng</a></li>
					<li><a href="{{URL::route('customer.logout')}}" rel="nofollow"><i class="glyphicon glyphicon-share-alt"></i> Thoát</a></li>
				</ul>
			</div>
		</div>
		@endif
	</div>
</div>
@if(sizeof($arrBannerHead) > 0)
<div class="line-ads">
	@if(isset($arrBannerHead) && sizeof($arrBannerHead) > 0)
		<div class="container">
			@if(sizeof($arrBannerHead) > 0)
				<div class="box-ads" >
					@foreach($arrBannerHead as $key_posi_header =>$bannerShowHeader)
						<ul class="rslides" id="sliderHead_{{$key_posi_header}}">
							@foreach($bannerShowHeader as $sliderHeader)
								<div class="slide ">
									<a @if($sliderHeader->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($sliderHeader->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($sliderHeader->banner_link != '') {{$sliderHeader->banner_link}} @else javascript:void(0) @endif" title="{{$sliderHeader->banner_name}}">
										<img src="{{ThumbImg::thumbImageBannerNormal($sliderHeader->banner_id,$sliderHeader->banner_parent_id, $sliderHeader->banner_image, CGlobal::sizeImage_1010,CGlobal::sizeImage_90, $sliderHeader->banner_name,true,true)}}" alt="{{$sliderHeader->banner_name}}" />
									</a>
								</div>
							@endforeach
						</ul>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#sliderHead_{{$key_posi_header}}").responsiveSlides({
									maxwidth: 1000,
									speed: 800,
									timeout: 5000,
								});
							});
						</script>
					@endforeach
				</div>
			@endif
		</div>
	@endif
</div>
@endif
@if($messages != '')
<div class="line-messages">
	<div class="container">
		{{$messages}}
	</div>
</div>
@endif