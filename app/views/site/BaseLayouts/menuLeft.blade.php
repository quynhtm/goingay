@if(Route::currentRouteName() == 'site.home')
<!-- Home Page -->
<div class="col-left-200">
	<ul class="box-menu-category">
		<li>
			<a href="" class="act"><i class="fa fa-home"></i>Trang chủ</a>
		</li>
		<li>
			<a href="{{URL::route('site.home')}}/mua-ban-nha-dat-1122.html"><i class="fa fa-building"></i> Mua bán nhà đất </a>
		</li>
		<li>
			<a href=""><i class="fa fa-building-o"></i> Thuê nhà đất </a>
		</li>
		<li>
			<a href=""><i class="fa fa-car"></i> Ôtô </a>
		</li>
		<li>
			<a href=""><i class="fa fa-bicycle"></i> Xe máy - Xe đạp </a>
		</li>
		<li>
			<a href=""><i class="fa fa-mortar-board"></i> Tuyển sinh - Tuyển dụng </a>
		</li>
		<li>
			<a href="/dien-thoai-sim"><i class="fa fa-mobile-phone"></i> Điện thoại - Sim </a>
		</li>
		<li>
			<a href="/pc-laptop"><i class="fa fa-laptop"></i> PC - Laptop </a>
		</li>
		<li>
			<a href="/dien-tu-ky-thuat-so"><i class="fa fa-desktop"></i> Điện tử - Kỹ thuật số </a>
		</li>
		<li>
			<a href="/thoi-trang-lam-dep"><i class="fa fa-child"></i> Thời trang - Làm đẹp </a>
		</li>
		<li>
			<a href="/am-thuc-du-lich"><i class="fa fa-cutlery"></i> Ẩm thực - Du lịch </a>
		</li>
		<li>
			<a href="/dich-vu"><i class="fa fa-dropbox"></i> Dịch vụ </a>
		</li>
		<li>
			<a href="/khac"><i class="fa fa-asterisk"></i> Khác </a>
		</li>
	</ul>
	@if(sizeof($arrBannerLeft) > 0)
	<div class="box-ads">
		<ul class="rslides" id="sliderLeft">
			@foreach($arrBannerLeft as $slider)
			<?php 
			if($slider->banner_is_rel == 0){
				$rel = 'rel="nofollow"';
			}else{
				$rel = '';
			}
			if($slider->banner_is_target == 0){
				$target = 'target="_blank"';
			}else{
				$target = '';
			}
			
			$banner_is_run_time = 1;
			if($slider->banner_is_run_time == CGlobal::status_hide){
				$banner_is_run_time = 1;
			}else{
				$banner_start_time = $slider->banner_start_time;
				$banner_end_time = $slider->banner_end_time;
				$date_current = time();
			
				if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
					if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
						$banner_is_run_time = 1;
					}
				}else{
					$banner_is_run_time = 0;
				}
			}
			?>
			@if($banner_is_run_time == 1)
			<div class="slide ">
				<a {{$target}} {{$rel}} href="@if($slider->banner_link != '') {{$slider->banner_link}} @else javascript:void(0) @endif" title="{{$slider->banner_name}}">
					<img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_BANNER, $slider->banner_id, $slider->banner_image, 200, 600, '', true, true, false)}}" alt="{{$slider->banner_name}}" />
				</a>
			</div>
			@endif
			@endforeach
		 </ul>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#sliderLeft").responsiveSlides({
				    maxwidth: 1000,
				    speed: 800,
				    timeout: 10000,
			    });
			});
		</script>
	</div>
	@endif
</div>
@else
<!-- Other Page -->
<div class="col-left-5">
	<ul class="list-item-panel-icon">
		<li class="fst">
			<a href=""><i class="fa fa-home">&nbsp;</i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-building"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-building-o"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-car"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-bicycle"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-mortar-board"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-mobile-phone"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-laptop"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-desktop"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-child"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-cutlery"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-dropbox"></i></a>
		</li>
		<li>
			<a href=""><i class="fa fa-asterisk"></i></a>
		</li>
	</ul>
</div>
@endif