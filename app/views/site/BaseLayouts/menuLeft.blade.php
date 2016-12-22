@if(Route::currentRouteName() == 'site.home')
<!-- Home Page -->
<div class="col-left-200">
	<ul class="box-menu-category">
		<li>
			<a title="Trang chủ" href="{{URL::route('site.home')}}" @if(Route::currentRouteName() == 'site.home')class="act"@endif><i class="fa fa-home"></i>Trang chủ</a>
		</li>
		@if(!empty($menuCategoriessAll))
		@foreach($menuCategoriessAll as $cat)
		<li>
	        <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @if(isset($catid) && $catid == $cat['category_id']) class="act" @endif><i class="{{$cat['category_icons']}}"></i>{{$cat['category_name']}}</a>
	    </li>
		@endforeach
		@endif
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
					<img src="{{ThumbImg::thumbImageBannerNormal($slider->banner_id,$slider->banner_parent_id, $slider->banner_image, CGlobal::sizeImage_200,CGlobal::sizeImage_600, $slider->banner_name,true,true)}}" alt="{{$slider->banner_name}}" />
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
				    timeout: 5000,
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
			<a title="Trang chủ" href="{{URL::route('site.home')}}" @if(Route::currentRouteName() == 'site.home')class="act"@endif><i class="fa fa-home"></i></a>
		</li>
		@if(!empty($menuCategoriessAll))
		@foreach($menuCategoriessAll as $cat)
		<li>
	        <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @if(isset($catid) && $catid == $cat['category_id']) class="act" @endif><i class="{{$cat['category_icons']}}"></i></a>
	    </li>
		@endforeach
		@endif
	</ul>
</div>
@endif