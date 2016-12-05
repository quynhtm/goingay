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
					<div class="main-img">
						<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/30/583e3ac6909fb-Image-307354715-ExtractWord-0-8075-5937-1480404429_300x180.png" alt="event_img">
					</div>
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
		</div>
	</div>
</div>