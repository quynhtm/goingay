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
									<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemCate->item_id, $itemCate->item_image, CGlobal::sizeImage_200)}}" alt="{{$itemCate->item_name}}" title="{{$itemCate->item_name}}">
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
					<div class="text-right">
						{{$paging}}
					</div>
				</div>
			@endif
		</div>

		<!--quảng cáo bên phải-->
		@if(isset($arrBannerRight) && sizeof($arrBannerRight) > 0)
				<!-- Home Page -->
		<div class="col-327 pull-right">
			<div class="box-ads">
				<ul class="rslides" id="sliderRight">
					@foreach($arrBannerRight as $slider)
						<?php
						if($slider->banner_is_rel == 0){
							$rel = 'rel="nofollow"';
						}else{
							$rel = '';
						}
						if($slider->banner_is_target == 0){
							$target = 'target="_blank"';
						}else{
							$target = '';
						}

						$banner_is_run_time = 1;
						if($slider->banner_is_run_time == CGlobal::status_hide){
							$banner_is_run_time = 1;
						}else{
							$banner_start_time = $slider->banner_start_time;
							$banner_end_time = $slider->banner_end_time;
							$date_current = time();

							if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
								if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
									$banner_is_run_time = 1;
								}
							}else{
								$banner_is_run_time = 0;
							}
						}
						?>
						@if($banner_is_run_time == 1)
							<div class="slide text-center">
								<a {{$target}} {{$rel}} href="@if($slider->banner_link != '') {{$slider->banner_link}} @else javascript:void(0) @endif" title="{{$slider->banner_name}}">
									<img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_BANNER, $slider->banner_id, $slider->banner_image, 300, 0, '', true, true, false)}}" alt="{{$slider->banner_name}}" />
								</a>
							</div>
						@endif
					@endforeach
				</ul>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#sliderRight").responsiveSlides({
							maxwidth: 1000,
							speed: 800,
							timeout: 10000,
						});
					});
				</script>
			</div>
		</div>
		@endif
	</div>
</div>