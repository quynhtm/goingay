<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-building"></i>Kết quả tìm kiếm</a></h2>
	</div>
	<div class="content-boxcat">
		<div class="col-653 pull-left">
			@if(isset($resultSearch) && !empty($resultSearch))
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
						@foreach ($resultSearch as $keyc => $itemCate)
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
				</div>
				<div class="text-right">
					{{$paging}}
				</div>
			@endif
		</div>

		<!--quảng cáo bên phải-->
		@if(isset($arrBannerRight) && sizeof($arrBannerRight) > 0)
				<!-- Home Page -->
		<div class="col-327 pull-right">
			@if(sizeof($arrBannerRight) > 0)
				<div class="box-ads" >
					@foreach($arrBannerRight as $key_position =>$bannerShow)
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
									timeout: 5000,
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