<div class="col-left-74">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-user"></i>Thành viên</a></h2>
	</div>
	@if(isset($user_customer) && !empty($user_customer))
	<div class="content-info">
		<div class="box-avatar">
			<img class="avatar" alt="avatar" src="https://stmy.vnexpress.net/myvne/i/v1/graphics/img_60x60.gif" >
			<div class="name-avatar">@if(isset($user_customer['customer_name'])){{$user_customer['customer_name']}}@endif</div>
			<div class="date">
				<span class="icon-timeup"></span>Gia nhập ngày : <strong>@if(isset($user_customer['customer_time_created'])){{date('d/m/Y',$user_customer['customer_time_created'])}}@endif</strong>
			</div>
		</div>
		@if(isset($messages) && $messages !='')
		{{$messages}}
		@endif
		<div >
			{{Form::open(array('method' => 'POST','role'=>'form','url' =>"thay-doi-thong-tin.html"))}}
				<div class="box-top-common">
					<div class="line">
						<div class="box-item-455">
							<p>Họ và tên<span class="required" aria-required="true">*</span></p>
							<input name="customer_name" value="@if(isset($user_customer['customer_name'])){{$user_customer['customer_name']}}@endif" placeholder="Nhập vào họ và tên" type="text">
						</div>
						<div class="box-item-455 ext">
							<p>Số điện thoại liên hệ<span class="required" aria-required="true">*</span></p>
							<input name="customer_phone" value="@if(isset($user_customer['customer_phone'])){{$user_customer['customer_phone']}}@endif" placeholder="Nhập vào số điện thoại" type="text">
						</div>
					</div>
					<div class="line">
						<div class="box-item-455">
							<p>Đổi mật khẩu</p>
							<input name="customer_password" id="customer_password" value="" placeholder="Nhập để thay đổi mật khẩu" type="password">
						</div>
						<div class="box-item-455 ext">
							<p>&nbsp;</p>
							<a href="javascript:void(0);" onclick="USER_CUSTOMMER.changePassCustomer();"class="btn btn-primary"><i class="fa fa-refresh"></i> Đổi mật khẩu</a>
						</div>
					</div>
					<div class="line">
						<div class="box-item-455">
							<p>Email<span class="required" aria-required="true">*</span></p>
							<input name="customer_email" value="@if(isset($user_customer['customer_email'])){{$user_customer['customer_email']}}@endif" placeholder="Nhập vào địa chỉ email" readonly class="upload_input" type="text">
						</div>
						<div class="box-item-455 ext">
							<div class="mail-show">
								<input name="customer_show_email" value="1" @if(isset($user_customer['customer_show_email']) && $user_customer['customer_show_email'] == 1)checked @endif class="checkbox" type="checkbox">
								<span class="hien_email">Hiển thị</span>
							</div>
						</div>
					</div>
					<div class="line">
						<div class="box-item-455 unit">
							<p>Tỉnh/Thành: <span class="required">*</span></p>
							<select class="select_s" name="customer_province_id" id="customer_province_id" onchange="USER_CUSTOMMER.getDistrictInforCustomer();">
								{{$optionProvince}}
							</select>
						</div>
						<div class="box-item-455 unit">
							<p>Quận/huyện: <span class="required">*</span></p>
							<select class="select_s" name="customer_district_id" id="customer_district_id">
								{{$optionDistrict}}
							</select>
						</div>
					</div>
					<div class="line">
						<p>Địa chỉ<span class="required">*</span></p>
						<input name="customer_address" value="@if(isset($user_customer['customer_address'])){{$user_customer['customer_address']}}@endif" placeholder="Nhập vào địa chỉ" type="text">
					</div>
				</div>
				<div class="box-top-common">
					<label class="bdbt">
						<span>Thông tin riêng</span>
					</label>
					<div class="line">
						<div class="box-item-455 gender">
							<p>Giới tính: </p>
							<select class="select_s" name="customer_gender">
								<option value="">Chọn giới tính</option>
								<option value="{{CGlobal::CUSTOMER_GENDER_BOY}}" @if(isset($user_customer['customer_gender']) && $user_customer['customer_gender'] == CGlobal::CUSTOMER_GENDER_BOY)selected @endif>Nam</option>
								<option value="{{CGlobal::CUSTOMER_GENDER_GIRL}}" @if(isset($user_customer['customer_gender']) && $user_customer['customer_gender'] == CGlobal::CUSTOMER_GENDER_GIRL)selected @endif>Nữ</option>
							</select>
						</div>
						<div class="box-item-455 born">
							<p>Ngày sinh: </p>
							<input name="customer_birthday" placeholder="dd/mm/yyyy" value="@if(isset($user_customer['customer_birthday'])){{$user_customer['customer_birthday']}}@endif" autocomplete="off" type="text">
						</div>
					</div>
					<div class="line">
						<p>Thời gian liên hệ tốt nhất</p>
						<input name="customer_about" value="@if(isset($user_customer['customer_address'])){{$user_customer['customer_address']}}@endif"type="text">
					</div>
					<div class="line">
						<button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Cập nhật thông tin</button>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
	@endif
</div>
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