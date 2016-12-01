<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-building"></i>@if(isset($arrCategory[$category_id])){{$arrCategory[$category_id]}} @endif</a></h2>
	</div>
	@if(isset($resultHot) && !empty($resultHot))
	<div class="content-boxcat">
		@foreach ($resultHot as $keyh => $itemHot)
			<div class="one-focus-item">
				<div class="item-wrap">
					<div class="thumb-image">
						<a class="image-item" title="{{$itemHot->item_name}}" href="{{FunctionLib::buildLinkDetailItem($itemHot->item_id,$itemHot->item_name,$itemHot->item_category_id)}}">
							@if($itemHot->item_image != '')
							<span>
								<img itemprop="image" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemHot->item_id, $itemHot->item_image, CGlobal::sizeImage_300)}}" title="{{$itemHot->item_name}}" alt="{{$itemHot->item_name}}">
							</span>
							@endif
							@if($itemHot->item_type_price == CGlobal::TYPE_PRICE_NUMBER)
								<span class="price-item">{{FunctionLib::numberFormat($itemHot->item_price_sell)}} đ</span>
							@else
								<span class="price-item">Liên hệ</span>
							@endif
						</a>
					</div>
					<div class="title-item">
						<h2>
							<a href="{{FunctionLib::buildLinkDetailItem($itemHot->item_id,$itemHot->item_name,$itemHot->item_category_id)}}" title="{{$itemHot->item_name}}">{{$itemHot->item_name}}</a>
						</h2>
					</div>
					<div class="info-item">
						<ul>
							<li class="pull-left local"><i class="fa fa-location-arrow"></i><a href="">@if(isset($arrProvince[$itemHot->item_province_id])){{$arrProvince[$itemHot->item_province_id]}}@else Toàn quốc @endif</a></li>
							<li class="pull-right time-post"><i class="fa fa-clock-o"></i>{{date('H:i',$itemHot->time_ontop)}} - {{date('d/m/Y',$itemHot->time_ontop)}}</li>
						</ul>
					</div>
				</div>
			</div>
		@endforeach
	</div>
	@endif

	<div class="content-boxcat">
		<div class="col-653 pull-left">
			<div class="form-seach-inboxcat">
				<h2>Tìm kiếm @if(isset($arrCategory[$category_id])){{$arrCategory[$category_id]}} @endif</h2>
				<form>
					<input class="seach-keyword" placeholder="Nhập từ khóa tìm kiếm hoặc tỉnh thành" name="q" value="" autocomplete="off" type="text">
					<input class="submit-seach" value="Tìm kiếm" type="submit">
				</form>
			</div>
			@if(isset($resultItemCategory) && !empty($resultItemCategory))
			<div class="filter-item">
				<div class="filter-list-action">
					<ul>
						<li class="sort"><a href=""><i class="fa fa-list"></i>Sắp xếp</a></li>
						<li class="active"><a href=""><i class="fa fa-sort-numeric-asc"></i>Mới cập nhật</a></li>
					</ul>
				</div>
			</div>
			<div class="list-item-filter">
				<ul>
					@foreach ($resultItemCategory as $keyc => $itemCate)
					<li>
						<a class="img" href="{{FunctionLib::buildLinkDetailItem($itemCate->item_id,$itemCate->item_name,$itemCate->item_category_id)}}">
                           <img src="http://img.f1.raovat.vnecdn.net/images/2016/11/22/5833e786e9beb-Chung-cu-imperia-sky-garden-500x450_200x120.jpg" alt="Duy nhất tại Q.Thanh Xuân - CHCC 2PN 1,3 tỷ" title="Duy nhất tại Q.Thanh Xuân - CHCC 2PN 1,3 tỷ">
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
				<div class="text-right">
					{{$paging}}
				</div>
			</div>
			@endif
		</div>
		<div class="col-327 pull-right">
			<div class="box-ads">
				<img src="http://static.eclick.vn/uploads/source/2016/10/31/87792651f32f26t98052y3724.jpeg">
			</div>
		</div>
	</div>
</div>