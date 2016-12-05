<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-newspaper-o"></i>Tin tức</a></h2>
	</div>
	<div class="content-boxcat">
		<div class="col-653 pull-left">
			<div class="list-item-filter news">
				@if(!empty($arrListNew))
					@foreach ($arrListNew as $keyNew => $itemNew)
						<div class="item-post">
							<a title="{{$itemNew['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($itemNew['news_id'],$itemNew['news_title'])}}">
								<h2 class="post-title">{{$itemNew['news_title']}}</h2>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="row">
										<div class="post-img">
											<img alt="{{$itemNew['news_title']}}" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $itemNew['news_id'],$itemNew['news_image'], CGlobal::sizeImage_300,  '', true, CGlobal::type_thumb_image_banner, false)}}">
										</div>
									</div>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 line-post-data">
									<div class="post-data">
										<div class="post-content">{{$itemNew['news_desc_sort']}} </div>
									</div>
								</div>
							</a>
						</div>
					@endforeach
				@endif
			</div>
		</div>
		<div class="col-327 pull-right">
			<div class="event-box">
				<div class="event-box-title">Đối tác</div>
				<div class="even-box-content">
					<div class="main-img">
						<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/30/583e3ac6909fb-Image-307354715-ExtractWord-0-8075-5937-1480404429_300x180.png" alt="event_img">
					</div>
					<div class="main-img">
						<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/30/583e3ac6909fb-Image-307354715-ExtractWord-0-8075-5937-1480404429_300x180.png" alt="event_img">
					</div>
					<div class="main-img">
						<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/30/583e3ac6909fb-Image-307354715-ExtractWord-0-8075-5937-1480404429_300x180.png" alt="event_img">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>