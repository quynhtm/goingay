<div class="col-left-92">
	<div class="head-info">
		<h2><a href="#"><i class="fa fa-newspaper-o"></i>Tin tức</a></h2>
	</div>
	<div class="content-boxcat">
		<div class="col-653 pull-left">
			@if(sizeof($arrListNew) > 0)
				<div class="list-item-post ext">
					<div class="row">
						@foreach($arrListNew as $k=>$item)
						@if($k < 1)
							<div class="col-lg-8 col-md-8 col-sm-12">
								<div class="item-post-last">
									<a title="{{stripslashes($item['news_title'])}}" href="{{FunctionLib::buildLinkDetailNews($item['news_id'],$item['news_title'])}}">
										<div class="post-img">
											@if($item['news_image'] != '')
												<img alt="{{$item['news_title']}}" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'],$item['news_image'], CGlobal::sizeImage_500,  '', true, CGlobal::type_thumb_image_product, false)}}">
												<div class="post-format">
													<i class="fa fa-file-text"></i>
												</div>
											@endif
										</div>
										<div class="post-data">
											<h2 class="post-title">{{stripslashes($item['news_title'])}}</h2>
											<div class="date">
												<i class="icon-date"></i>
												{{date('d/m/Y h:i', $item['news_create'])}}
											</div>
											<div class="post-content">{{stripslashes($item['news_desc_sort'])}}</div>
										</div>
									</a>
								</div>
							</div>
						@endif
						@endforeach
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="row">
								<ul class="event-block-list item item-news-post">
									@foreach($arrListNew as $k=>$item)
										@if($k >= 1 && $k <=6)
											<li>
												<div class="ithumb">
													@if($item['news_image'] != '')
														<img alt="{{$item['news_title']}}" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'],$item['news_image'], CGlobal::sizeImage_500,  '', true, CGlobal::type_thumb_image_product, false)}}">
													@endif
												</div>
												<a title="{{stripslashes($item['news_title'])}}" href="{{FunctionLib::buildLinkDetailNews($item['news_id'],$item['news_title'])}}">
													{{stripslashes($item['news_title'])}}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="list-item-post bdt10">
					@foreach($arrListNew as $k=>$item)
						@if($k > 6)
							<div class="item-post-seo">
								<a title="{{stripslashes($item['news_title'])}}" href="{{FunctionLib::buildLinkDetailNews($item['news_id'],$item['news_title'])}}">
									<div class="col-lg-3 col-md-3 col-sm-12">
										<div class="row">
											<div class="post-img">
												@if($item['news_image'] != '')
													<img alt="{{$item['news_title']}}" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'],$item['news_image'], CGlobal::sizeImage_500,  '', true, CGlobal::type_thumb_image_product, false)}}">
													<div class="post-format">
														<i class="fa fa-file-text"></i>
													</div>
												@endif
											</div>
										</div>
									</div>

									<div class="col-lg-9 col-md-9 col-sm-9 line-post-data">
										<div class="post-data">
											<h2 class="post-title">{{stripslashes($item['news_title'])}}</h2>
											<div class="date">
												<i class="icon-date"></i>
												{{date('d/m/Y h:i', $item['news_create'])}}
											</div>
											<div class="post-content">{{stripslashes($item['news_desc_sort'])}}</div>
										</div>
									</div>
								</a>
							</div>
						@endif
					@endforeach
					<div class="show-box-paging">{{$paging}}</div>
				</div>
			@endif
		</div>
		<div class="col-327 pull-right">
			<div class="event-box">
				@if(sizeof($arrBannerRight) > 0)
					<div class="box-ads" >
						@foreach($arrBannerRight as $key_position =>$bannerShow)
							<script type="text/javascript">
								var time_show = Math.floor(Math.random() * 3000) + 2000;//[2000->5000]
							</script>
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
										timeout: time_show,
									});
								});
							</script>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>
</div>