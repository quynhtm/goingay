<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-newspaper-o"></i>Tin tức</a></h2>
	</div>
	<div class="content-boxcat">
		<div class="col-653 pull-left">
			<div class="list-item-news news">
				@if(!empty($inforNew))
				<h1 class="post-title-view">{{$inforNew->news_title}}</h1>
				<div class="post-intro-view">{{$inforNew->news_desc_sort}}</div>
				<div class="post-content-view">
					{{$inforNew->news_content}}
				</div>
				@endif
			</div>
		</div>
		<div class="col-327 pull-right">
			<div class="event-box">
				<div class="event-box-title">Tin nổi bật</div>
				<div class="even-box-content">
					@if(!empty($arrListNew))
					<div class="main-text">
						<ul class="event-block-list">
							@foreach ($arrListNew as $keyNew => $itemNew)
								<li>
									<a href="{{FunctionLib::buildLinkDetailNews($itemNew['news_id'],$itemNew['news_title'])}}" title="{{$itemNew['news_title']}}">{{ $itemNew['news_title'] }}</a>
								</li>
							@endforeach
						</ul>
					</div>
					@endif
				</div>
			</div>
			@if(sizeof($arrBannerRight) > 0)
				<div class="box-ads" >
					@foreach($arrBannerRight as $key_position =>$bannerShow)
						<ul class="rslides" id="sliderRight_{{$key_position}}" style="padding-bottom: 25px">
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
								jQuery("#sliderRight_{{$key_position}}").responsiveSlides({
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
	</div>
</div>