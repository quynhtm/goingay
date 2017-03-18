<div class="col-left-92">
	<div class="head-info">
		@if($inforNew->news_type == CGlobal::NEW_TYPE_GIOI_THIEU)
			<h2><a href="javascript:void(0)"><i class="fa fa-newspaper-o"></i>{{$categoryNewName}}</a></h2>
		@else
			<h2>
				<a href="{{URL::route('Site.pageNews')}}"><i class="fa fa-newspaper-o"></i>
					Tin tức
				</a>
				<a href="javascript:void (0);"> &rsaquo; </a>
				<a href="{{FunctionLib::buildLinkCateNews($inforNew->news_category,$categoryNewName)}}">
					{{$categoryNewName}}
				</a>
			</h2>
			
			<div class="like-social pull-right">
			<a class="share-google" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên google" data-url="{{$url_link_share}}">
				<i  class="icon-share fa fa-google-plus"></i>
			</a>
			<a class="share-facebook" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên facebook" data-url="{{$url_link_share}}">
				<i class="icon-share fa fa-facebook"></i>
			</a>
		</div>
		@endif
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

			@if($inforNew->news_type == CGlobal::NEW_TYPE_TIN_TUC)
			<div class="list-item-post bdt10">
				@foreach($arrListNew as $k=>$item)
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
				@endforeach
			</div>
			@endif
		</div>
		<div class="col-327 pull-right">
			<div class="event-box">
				@if($inforNew->news_type == CGlobal::NEW_TYPE_GIOI_THIEU)
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
				@else
					<div class="event-box-title">Tin rao mới nhất</div>
					<div class="even-box-content">
						@if(!empty($resultItem))
						<div class="main-text">
							<ul class="event-block-list">
								@foreach ($resultItem as $keyItem => $itemItem)
									<li>
										<a href="{{FunctionLib::buildLinkDetailItem($itemItem->item_id,$itemItem->item_name,$itemItem->item_category_id)}}" title="{{$itemItem->item_name}}">
											{{$itemItem->item_name}}
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						@endif
					</div>
				@endif
			</div>
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