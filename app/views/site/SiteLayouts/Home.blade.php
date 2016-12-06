<div class="col-right-765">
	<div class="box-home-post-hot">
		<ul>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/02/581844b2127a0-20161021144432-4d0e_300x180.jpg" title="">
					<span class="price-hot" href="">1.100.000.000 đ</span>
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f2.raovat.vnecdn.net/images/2016/11/01/581720390340c-t-i-xu-ng_300x180.jpg" title="">
					<span class="price-hot" href="">1.100.000.000 đ</span>
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f2.raovat.vnecdn.net/images/2016/10/27/580dba08eadd8-phoicanh-tong-the-1-300x184_300x180.jpg" title="">
					<span class="price-hot" href="">1.100.000.000 đ</span>
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
		</ul>
	</div>
	<div class="box-home-post-hot ext">
		<ul>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/02/581844b2127a0-20161021144432-4d0e_300x180.jpg" title="">
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f2.raovat.vnecdn.net/images/2016/11/01/581720390340c-t-i-xu-ng_300x180.jpg" title="">
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f2.raovat.vnecdn.net/images/2016/10/27/580dba08eadd8-phoicanh-tong-the-1-300x184_300x180.jpg" title="">
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f1.raovat.vnecdn.net/images/2016/11/02/581844b2127a0-20161021144432-4d0e_300x180.jpg" title="">
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
			<li>
			   <a class="img-hot" href="">
					<img src="http://img.f2.raovat.vnecdn.net/images/2016/11/01/581720390340c-t-i-xu-ng_300x180.jpg" title="">
			   </a>
			   <h2>
					<a itemprop="name" class="title-item-hot" href="" title="">Chỉ 350tr nhận nhà ngay T11 + CK 45tr - LH: 0945212476</a>
			   </h2>
			</li>
		</ul>
	</div>
	<div class="box-home-category">
		<ul class="item-home-cat">
			<?php $stt = 1?>
			@foreach ($resultHome as $keyc => $itemHome)
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
											<img itemprop="image" src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemShow['item_id'], $itemShow['item_image'], CGlobal::sizeImage_100)}}" title="{{$itemShow['item_name']}}" alt="{{$itemShow['item_name']}}" height="60"width="120">
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
													<a href="">@if(isset($arrProvince[$itemShow['item_province_id']])){{$arrProvince[$itemShow['item_province_id']]}}@else Toàn quốc @endif</a>
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
