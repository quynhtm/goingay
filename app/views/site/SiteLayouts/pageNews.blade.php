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
					
				</div>
			</div>
		</div>
	</div>
</div>