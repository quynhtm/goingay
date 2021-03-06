<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-building"></i>Tin đã đăng @if(!empty($arrCustomer) && isset($arrCustomer->customer_name)) của {{$arrCustomer->customer_name}} @endif</a></h2>
	</div>
	@if(isset($resultHot) && !empty($resultHot))
		<div class="content-boxcat">
			@foreach ($resultHot as $keyh => $itemHot)
				<div class="one-focus-item">
					<div class="item-wrap">
						<div class="thumb-image">
							<a class="image-item" title="{{$itemHot->item_name}}" href="{{FunctionLib::buildLinkDetailItem($itemHot->item_id,$itemHot->item_name,$itemHot->item_category_id)}}">
								<span>
									<img itemprop="image" {{CGlobal::size_imge_show_list_180}} src="{{ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $itemHot->item_id,$itemHot->item_category_id, $itemHot->item_image, CGlobal::sizeImage_500)}}" title="{{$itemHot->item_name}}" alt="{{$itemHot->item_name}}">
								</span>
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
								<li class="pull-left local"><i class="fa fa-location-arrow"></i>
									<a href="{{FunctionLib::buildLinkCategory($itemHot->item_category_id, $itemHot->item_category_name,$itemHot->item_province_id, $itemHot->item_province_name)}}" title="Rao vặt theo tỉnh thành {{$itemHot->item_province_name}}">
										@if(isset($arrProvince[$itemHot->item_province_id])){{$arrProvince[$itemHot->item_province_id]}}@else Toàn quốc @endif
									</a>
								</li>
								<li class="pull-right time-post"><i class="fa fa-clock-o"></i>{{date('H:i',$itemHot->time_ontop)}} - {{date('d/m/Y',$itemHot->time_ontop)}}</li>
							</ul>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@endif
	<div class="head-info">
		<h2><a href=""><i class="fa fa-user"></i>Thành viên</a></h2>
	</div>
	<div class="content-info">
		<div class="box-avatar ext-bd">
			<img class="avatar" alt="avatar" src="{{URL::route('site.home')}}/assets/frontend/img/avatar.png">
			<div class="name-avatar">{{$arrCustomer->customer_name}}</div>
			<div class="date">
				<span class="icon-timeup"></span>Gia nhập ngày : <strong>{{date('d/m/Y', $arrCustomer->customer_time_created)}}</strong>
				@if($arrCustomer->customer_phone != '')
				<span class="fa fa-phone mgl50"></span> Số điện thoại liên hệ : <strong>{{$arrCustomer->customer_phone}}</strong>
				@endif
			</div>
			
			<div class="like-social like-page-customer">
				<a class="share-google" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên google" data-url="{{$url_link_share}}">
					<i  class="icon-share fa fa-google-plus"></i>
				</a>
				<a class="share-facebook" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên facebook" data-url="{{$url_link_share}}">
					<i class="icon-share fa fa-facebook"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="content-boxcat">
		<div class="col-653 pull-left">
			@if(isset($resultItemCategory) && !empty($resultItemCategory))
				<div class="filter-item">
					<div class="filter-list-action">
						<ul>
							<li><i class="fa fa-list"></i>Tổng số tin đăng: <b>{{$total}}</b></li>
						</ul>
					</div>
				</div>
				<div class="list-item-filter">
					<ul>
						@foreach ($resultItemCategory as $keyc => $itemCate)
							<li>
								<a class="img" href="{{FunctionLib::buildLinkDetailItem($itemCate->item_id,$itemCate->item_name,$itemCate->item_category_id)}}">
									<img {{CGlobal::size_imge_show_list_60}} src="{{ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $itemCate->item_id,$itemCate->item_category_id, $itemCate->item_image, CGlobal::sizeImage_200)}}" alt="{{$itemCate->item_name}}" title="{{$itemCate->item_name}}">
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
											<a href="{{FunctionLib::buildLinkCategory($itemCate->item_category_id, $itemCate->item_category_name,$itemCate->item_province_id, $itemCate->item_province_name)}}" title="Rao vặt theo tỉnh thành {{$itemCate->item_province_name}}">
												@if(isset($arrProvince[$itemCate->item_province_id])){{$arrProvince[$itemCate->item_province_id]}}@else Toàn quốc @endif
											</a>
										</li>
										@if(isset($itemCate->time_ontop) && $itemCate->time_ontop > 0)
										<li class="date-uptop"><i class="fa fa-clock-o"></i> {{date('H:i - d/m/Y', $itemCate->time_ontop)}}</li>
										@endif
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
				</div>
				<div class="text-right">
					{{$paging}}
				</div>
			@endif
		</div>

		<!-- quang cao ben phải-->
		@if(isset($arrBannerRight) && sizeof($arrBannerRight) > 0)
			<div class="col-327 pull-right">
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
		@endif
	</div>
</div>