<div class="col-right-765">
	@if(!empty($resultHomeTop))
		<div class="box-home-post-hot">
			<ul>
				@foreach ($resultHomeTop as $keytop => $itemHomeTop)
					<li>
						<a class="img-hot" href="{{FunctionLib::buildLinkDetailItem($itemHomeTop['item_id'],$itemHomeTop['item_name'],$itemHomeTop['item_category_id'])}}" title="{{$itemHomeTop['item_name']}}">
							<img src="{{ ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $itemHomeTop['item_id'],$itemHomeTop['item_category_id'], $itemHomeTop['item_image'], CGlobal::sizeImage_500)}}" title="{{$itemHomeTop['item_name']}}" alt="{{$itemHomeTop['item_name']}}" >
							@if($itemHomeTop['item_type_price'] == CGlobal::TYPE_PRICE_NUMBER)
								<span class="price-hot">{{FunctionLib::numberFormat($itemHomeTop['item_price_sell'])}} đ</span>
							@else
								<span class="price-hot">Liên hệ</span>
							@endif
						</a>
					   <h2>
							<a itemprop="name" class="title-item-hot" href="{{FunctionLib::buildLinkDetailItem($itemHomeTop['item_id'],$itemHomeTop['item_name'],$itemHomeTop['item_category_id'])}}" title="{{$itemHomeTop['item_name']}}">{{$itemHomeTop['item_name']}}</a>
					   </h2>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if(!empty($resultHomeSlider))
	<div class="box-home-post-hot ext">
		<div id="owl-slider">
			@foreach ($resultHomeSlider as $keySlider => $itemHomeSlider)
			<div class="item">
				<a class="img-slider" href="{{FunctionLib::buildLinkDetailItem($itemHomeSlider['item_id'],$itemHomeSlider['item_name'],$itemHomeSlider['item_category_id'])}}" title="{{$itemHomeSlider['item_name']}}">
					<img src="{{ ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $itemHomeSlider['item_id'],$itemHomeSlider['item_category_id'], $itemHomeSlider['item_image'], CGlobal::sizeImage_200)}}" title="{{$itemHomeSlider['item_name']}}" alt="{{$itemHomeSlider['item_name']}}" >
			   </a>
			   <h2>
				   <a itemprop="name" class="title-item-hot" href="{{FunctionLib::buildLinkDetailItem($itemHomeSlider['item_id'],$itemHomeSlider['item_name'],$itemHomeSlider['item_category_id'])}}" title="{{$itemHomeSlider['item_name']}}">{{$itemHomeSlider['item_name']}}</a>
			   </h2>
			</div>
			@endforeach
		</div>
	</div>
	<script>
    $(document).ready(function(){
      $("#owl-slider").owlCarousel({
        items : 5,
        navigation : true,
      });
    });
    </script>

	@endif

	<div class="box-home-category">
		<ul class="item-home-cat">
			<?php $stt = 1?>
			@foreach ($resultHomeList as $keyc => $itemHome)
				@if(isset($itemHome['dataItem']) && !empty($itemHome['dataItem']))
					<li @if($stt %2 == 0) class="pull-right" @else class="pull-left" @endif>
						<div class="title-category">
							<a title="{{$itemHome['category_name']}}" href="{{FunctionLib::buildLinkCategory($keyc, $itemHome['category_name'])}}">
								<i class="{{$itemHome['category_icons']}}"></i> {{$itemHome['category_name']}}
							</a>
						</div>
						<div class="content-category">
							@foreach ($itemHome['dataItem'] as $kitem => $itemShow)
								<div class="line">
									<div class="thumb">
										<a href="{{FunctionLib::buildLinkDetailItem($itemShow['item_id'],$itemShow['item_name'],$itemShow['item_category_id'])}}" title="{{$itemShow['item_name']}}">
											<img itemprop="image" src="{{ ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $itemShow['item_id'],$itemShow['item_category_id'], $itemShow['item_image'], CGlobal::sizeImage_150)}}" title="{{$itemShow['item_name']}}" alt="{{$itemShow['item_name']}}" >
										</a>
									</div>
									<div class="round-titlebox">
										<div class="title-text">
											<h3>
												<a href="{{FunctionLib::buildLinkDetailItem($itemShow['item_id'],$itemShow['item_name'],$itemShow['item_category_id'])}}" title="{{$itemShow['item_name']}}" itemprop="name">{{$itemShow['item_name']}}</a>
											</h3>
										</div>
										<div class="location-price">
											<ul>
												<li class="local">
													<i class="fa fa-location-arrow"></i>
													<a href="{{FunctionLib::buildLinkCategory($itemShow['item_category_id'], $itemShow['item_category_name'],$itemShow['item_province_id'], $itemShow['item_province_name'])}}" title="Rao vặt theo tỉnh thành {{$itemShow['item_province_name']}}">
														@if(isset($arrProvince[$itemShow['item_province_id']])){{$arrProvince[$itemShow['item_province_id']]}}@else Toàn quốc @endif
													</a>
												</li>
												<li class="price">
													@if($itemShow['item_type_price'] == CGlobal::TYPE_PRICE_NUMBER)
														<a itemprop="price" href="#">{{FunctionLib::numberFormat($itemShow['item_price_sell'])}} đ</a>
													@else
														<a itemprop="price" href="#">Liên hệ</a>
													@endif
												</li>
											</ul>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</li>
						@if($stt %2 == 0) <div style="clear: both"></div> @endif
					<?php $stt ++; ?>
				@endif
			@endforeach
		</ul>
	</div>
</div>
