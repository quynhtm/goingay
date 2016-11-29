<div class="line-content">
	<div class="container">
		<div class="col-left-5">
			<ul class="list-item-panel-icon">
				<li class="fst">
			        <a href=""><i class="fa fa-home">&nbsp;</i></a>
			    </li>
			    <li>
				    <a href=""><i class="fa fa-building"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-building-o"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-car"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-bicycle"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-mortar-board"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-mobile-phone"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-laptop"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-desktop"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-child"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-cutlery"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-dropbox"></i></a>
				</li>
				<li>
				    <a href=""><i class="fa fa-asterisk"></i></a>
				</li>
			</ul>
		</div>

		<div class="col-left-74">
			<div class="head-info">
				<h2><a href=""><i class="fa fa-upload"></i> Đăng tin </a></h2>
			</div>
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				{{Form::open(array('role'=>'form','method' => 'POST','url' =>URL::route('customer.ItemsEdit',array('item_id'=>$item_id)),'files' => true))}}
				@if(isset($error) && !empty($error))
					<div class="alert alert-danger" role="alert">
						@foreach($error as $itmError)
							<p>{{ $itmError }}</p>
						@endforeach
					</div>
				@endif

				<div class="col-sm-12">
					<div class="form-group">
						<label for="name" class="control-label">Tên tin đăng <span class="red"> (*) </span></label>
						<input type="text" placeholder="Tên tin đăng" id="item_name" name="item_name"  class="form-control input-sm" value="@if(isset($data['item_name'])){{$data['item_name']}}@endif">
					</div>
				</div>

				<div class="clearfix"></div>
				<div style="float: left; width: 50%">
					<div class="col-sm-12">
						<div class="form-group">
							<label for="name" class="control-label">Danh mục<span class="red"> (*) </span></label>
							<div class="form-group">
								<select name="item_category_id" id="item_category_id" class="form-control input-sm">
									{{$optionCategory}}
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label for="name" class="control-label">Trạng thái Ẩn/Hiện</label>
							<div class="form-group">
								<select name="item_status" id="item_status" class="form-control input-sm">
									{{$optionStatusProduct}}
								</select>
							</div>
						</div>
					</div>
				</div>

				<div style="float: left; width: 50%">
					<div class="col-sm-12">
						<div class="form-group">
							<label for="name" class="control-label">Kiểu hiển thị giá<span class="red"> (*) </span></label>
							<div class="form-group">
								<select name="item_type_price" id="item_type_price" class="form-control input-sm">
									{{$optionTypePrice}}
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label for="name" class="control-label">Giá bán <span class="red"> (*) </span></label>
							<input type="text" placeholder="Giá bán" id="item_price_sell" name="item_price_sell" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['item_price_sell'])){{$data['item_price_sell']}}@endif">
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
				<div class="col-sm-12">
					<div class="form-group">
						<a href="javascript:;"class="btn btn-primary" onclick="SITE.uploadImagesProduct(2);">Upload ảnh </a>
						<input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['item_image'])){{$data['item_image']}}@endif">
					</div>
				</div>

				<div class="clearfix"></div>
				<div class="col-sm-12">
					<!--hien thi anh-->
					<ul id="sys_drag_sort" class="ul_drag_sort">
						@if(isset($arrViewImgOther))
							@foreach ($arrViewImgOther as $key => $imgNew)
								<li id="sys_div_img_other_{{$key}}" style="margin: 1px!important;">
									<div class='block_img_upload'>
										<img src="{{$imgNew['src_img_other']}}" height='100' width='100'>
										<input type="hidden" id="img_other_{{$key}}" name="img_other[]" value="{{$imgNew['img_other']}}" class="sys_img_other">
										<div class='clear'></div>
										<input type="radio" id="chẹcked_image_{{$key}}" name="chẹcked_image" value="{{$key}}" @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] ) checked="checked" @endif onclick="SITE.checkedImage('{{$imgNew['img_other']}}','{{$key}}');">
										<label for="chẹcked_image_{{$key}}" style='font-weight:normal'>Ảnh đại diện</label>

										<div class="clearfix"></div>
										<a href="javascript:void(0);" onclick="SITE.removeImage({{$key}},{{$item_id}},'{{$imgNew['img_other']}}');">Xóa ảnh</a>
										<span style="display: none"><b>{{$key}}</b></span>
									</div>
								</li>
								@if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] )
									<input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="{{$key}}">
								@endif
							@endforeach
						@else
							<input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="-1">
						@endif
					</ul>
				</div>

				<div class="clearfix"></div>
				<div class="col-sm-12">
					<div class="form-group">
						<label for="name" class="control-label">Thông tin chi tiết <span class="red"> (*) </span>
							<div class="controls"><button type="button" onclick="SITE.insertImageContentProduct()" class="btn btn-primary">Chèn ảnh vào nội dung</button></div>
						</label>
						<textarea class="form-control input-sm" rows="8" name="item_content" id="item_content">@if(isset($data['item_content'])){{$data['item_content']}}@endif</textarea>
					</div>
				</div>
				<div class="clearfix"></div>

				<div class="form-group col-sm-12 text-left">
					<button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Đăng tin</button>
				</div>
				<input type="hidden" id="id_hiden" name="id_hiden" value="{{$item_id}}"/>
				{{ Form::close() }}
			</div>
		</div>
		<script type="text/javascript">
			jQuery('.formatMoney').autoNumeric('init');
			CKEDITOR.replace('item_content', {height:600});
			function insertImgContent(src,name_product){
				CKEDITOR.instances.item_content.insertHtml('<img src="'+src+'" alt="'+name_product+'"/>');
			}
		</script>

		<div class="col-right-16">
			@if(sizeof($arrBannerRight) > 0)
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
					<div class="slide ">
						<a {{$target}} {{$rel}} href="@if($slider->banner_link != '') {{$slider->banner_link}} @else javascript:void(0) @endif" title="{{$slider->banner_name}}">
							<img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_BANNER, $slider->banner_id, $slider->banner_image, 200, 600, '', true, true, false)}}" alt="{{$slider->banner_name}}" />
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
			@endif
		</div>
	</div>
</div>
