@if(Route::currentRouteName() == 'site.home')
<!-- Home Page -->
<div class="col-left-200">
	<ul class="box-menu-category">
		@if(!empty($menuCategoriessAll))
		@foreach($menuCategoriessAll as $cat)
		<li>
	        <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @if(isset($catid) && $catid == $cat['category_id']) class="act" @endif><i class="{{$cat['category_icons']}}"></i>{{$cat['category_name']}}</a>
	    </li>
		@endforeach
		@endif
		<li class="fst">
			<a title="Hỗ trợ" href="http://raovat30s.vn/chi-tiet/tin-tuc-6/gioi-thieu-ve-raovat30s-vn.html" @if(Route::currentRouteName() == 'Site.pageDetailNew')class="act"@endif><i class="fa fa-weixin"></i> Hỗ trợ</a>
		</li>
	</ul>
	@if(sizeof($arrBannerShow) > 0)
	<div class="box-ads" >
		@foreach($arrBannerShow as $key_position =>$bannerShow)
			<ul class="rslides" id="sliderLeft_{{$key_position}}" style="padding-bottom: 25px">
				@foreach($bannerShow as $slider)
				<div class="slide ">
					<a @if($slider->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($slider->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($slider->banner_link != '') {{$slider->banner_link}} @else javascript:void(0) @endif" title="{{$slider->banner_name}}">
						<img src="{{ThumbImg::thumbImageBannerNormal($slider->banner_id,$slider->banner_parent_id, $slider->banner_image, CGlobal::sizeImage_200,CGlobal::sizeImage_600, $slider->banner_name,true,true)}}" alt="{{$slider->banner_name}}" />
					</a>
				</div>
				@endforeach
			 </ul>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#sliderLeft_{{$key_position}}").responsiveSlides({
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
@else
<!-- Other Page -->
<div class="col-left-5">
	<ul class="list-item-panel-icon">
		@if(!empty($menuCategoriessAll))
		@foreach($menuCategoriessAll as $cat)
		<li>
	        <a title="{{$cat['category_name']}}" href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @if(isset($catid) && $catid == $cat['category_id']) class="act" @endif><i class="{{$cat['category_icons']}}"></i></a>
	    </li>
		@endforeach
		@endif
		<li class="fst">
			<a title="Hỗ trợ" href="http://raovat30s.vn/chi-tiet/tin-tuc-6/gioi-thieu-ve-raovat30s-vn.html" @if(Route::currentRouteName() == 'Site.pageDetailNew')class="act"@endif><i class="fa fa-weixin"></i></a>
		</li>
	</ul>
</div>
@endif