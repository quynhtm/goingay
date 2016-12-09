<div class="col-left-92">
	<div class="head-info">
		<h2>
			<a title="{{$itemShow->item_category_name}}" href="{{FunctionLib::buildLinkCategory($itemShow->item_category_id, $itemShow->item_category_name)}}">
				<i class="fa fa-building"></i>{{$itemShow->item_category_name}}
			</a>
		</h2>
	</div>
	<div class="content-boxcat">
		<div class="slide-detail-post">
			<img {{CGlobal::size_imge_show_detail}} src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemShow->item_id, $itemShow->item_image, CGlobal::sizeImage_300)}}" title="{{$itemShow->item_name}}" alt="{{$itemShow->item_name}}">
		</div>
		<div class="info-detail-post">
			@if($itemShow->item_type_price == CGlobal::TYPE_PRICE_NUMBER)
				<h4 class="price-detail">{{FunctionLib::numberFormat($itemShow->item_price_sell)}} đ</h4>
			@else
				<h4 class="price-detail">Liên hệ</h4>
			@endif

			<h1 class="title-detail">{{$itemShow->item_name}}</h1>
			<div class="post-now">
				<i class="fa fa-clock-o"></i>{{date('H:i',$itemShow->time_ontop)}} - {{date('d/m/Y',$itemShow->time_ontop)}}
			</div>
			<p class="location">
				<i class="fa fa-location-arrow"></i>
				<span>@if(isset($arrProvince[$itemShow->item_province_id])){{$arrProvince[$itemShow->item_province_id]}}@else Toàn quốc @endif</span>
			</p>
			@if(!empty($arrCustomer))
			<div class="box-contact">
				<span class="arrow-box-before-contact"></span>
				<div class="head-contact"><h3>Thông tin liên hệ</h3></div>
				<p class="person-post">
					<i class="fa fa-user"></i>
					<span>@if($arrCustomer->customer_gender==CGlobal::CUSTOMER_GENDER_GIRL)Chị:@else Anh: @endif
						<a title="Tin đã đăng của {{$arrCustomer->customer_name}}" href="{{FunctionLib::buildLinkItemsCustomer($arrCustomer->customer_id, $arrCustomer->customer_name)}}">
							<strong>{{$arrCustomer->customer_name}}</strong>
						</a>
					</span>
				</p>
				<p class="info-post"><i class="fa fa-phone"></i> @if($arrCustomer->customer_phone != ''){{$arrCustomer->customer_phone}}@else Chưa cập nhật @endif </p>
				<p class="time-post">
					<i class="fa fa-clock-o"></i> @if($arrCustomer->customer_about != ''){{$arrCustomer->customer_about}}@else Chưa cập nhật @endif
				</p>
			</div>
			@endif
		</div>
	</div>


	<div class="content-boxcat">
		<div class="col-653 pull-left">
			<div class="detail-content-post">
				{{$itemShow->item_content}}
			</div>

			<div class="head-info">
				<h2>
					<a title="{{$itemShow->item_category_name}}" href="{{FunctionLib::buildLinkCategory($itemShow->item_category_id, $itemShow->item_category_name)}}">
						<i class="fa fa-building"></i>Tin khác cùng danh mục
					</a>
				</h2>
			</div>
			<div class="list-item-filter">
				@if(!empty($resultItemCategory))
				<ul>
					@foreach ($resultItemCategory as $keyc => $itemCate)
						<li>
							<a class="img" href="{{FunctionLib::buildLinkDetailItem($itemCate->item_id,$itemCate->item_name,$itemCate->item_category_id)}}">
								<img {{CGlobal::size_imge_show_list_60}} src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemCate->item_id, $itemCate->item_image, CGlobal::sizeImage_200)}}" alt="{{$itemCate->item_name}}" title="{{$itemCate->item_name}}">
							</a>
							<div class="title-post">
								<h2>
									<a href="{{FunctionLib::buildLinkDetailItem($itemCate->item_id,$itemCate->item_name,$itemCate->item_category_id)}}" title="{{$itemCate->item_name}}">
										{{$itemCate->item_name}}
									</a>
								</h2>
								<div class="pull-right">
									@if($itemCate->item_type_price == CGlobal::TYPE_PRICE_NUMBER)
										<span class="price"><a itemprop="price" href="#">{{FunctionLib::numberFormat($itemCate->item_price_sell)}} đ</a></span>
									@else
										<span class="price"><a itemprop="price" href="#">Liên hệ</a></span>
									@endif
								</div>
							</div>
							<div class="info-item">
								<ul class="pull-left">
									<li class="local">
										<i class="fa fa-location-arrow"></i>
										<a href="">@if(isset($arrProvince[$itemCate->item_province_id])){{$arrProvince[$itemCate->item_province_id]}}@else Toàn quốc @endif</a>
									</li>
									<li class="">
										<i class="fa fa-clock-o"></i> {{date('H:i',$itemCate->time_ontop)}} - {{date('d/m/Y',$itemCate->time_ontop)}}
									</li>
								</ul>
								<ul class="pull-right" style="display: none">
									<li>
										<i class="fa fa-minus"></i> 2
									</li>
									<li>
										<i class="fa fa-tint"></i> 1
									</li>
								</ul>
							</div>
						</li>
					@endforeach
				</ul>
				@endif
			</div>
		</div>
		<div class="col-327 pull-right">
			<div class="box-ads">
				<img src="http://static.eclick.vn/uploads/source/2016/10/31/87792651f32f26t98052y3724.jpeg">
			</div>
		</div>
	</div>
</div>