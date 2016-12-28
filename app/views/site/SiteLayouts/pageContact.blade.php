<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-newspaper-o"></i>Liên hệ</a></h2>
	</div>
	<div class="content-boxcat contact">
		<div class="col-653 pull-left">
			<div class="list-item-news news">
				{{Form::open(array('method' => 'POST', 'id'=>'formSendContact', 'class'=>'formSendContact', 'name'=>'txtForm'))}}
				<div class="col-lg-10 col-md-10 col-sm-10">
					<div class="row">
						<div class="form-group">
							<label class="control-label">Họ và tên<span>(*)</span></label>
							<input id="txtName" name="txtName" class="form-control" type="text">
						</div>
						<div class="form-group">
							<label class="control-label">Số điện thoại<span>(*)</span></label>
							<input id="txtMobile" name="txtMobile" class="form-control" type="text">
						</div>
						<div class="form-group">
							<label class="control-label">Email</label>
							<input id="txtEmail" name="txtEmail" class="form-control" type="text">
						</div>
						<div class="form-group">
							<label class="control-label">Tiêu đề liên hệ<span>(*)</span></label>
							<input id="txtTitle" name="txtTitle" class="form-control" type="text">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">Nội dung<span>(*)</span></label>
					<textarea id="txtMessage" name="txtMessage" class="form-control" rows="5"></textarea>
				</div>
				<div class="form-group">
					<label class="control-label labelInputCaptchar">Xác nhận<span>(*)</span></label>
					<input type="text" id="securityCode" name="captcha" maxlength="255" class="txtInputCaptchar"/>
					<img id="imageCaptchar" src="{{URL::route('site.home')}}/captcha?rand=<?php echo rand();?>" class="imageCaptchar">
					<a href="javascript:void(0)" class="iconRefreh" onclick="SITE.refreshCaptcha();" title="Mã an toàn mới"></a>
				</div>
				<div class="form-group mgt10">
					<button type="submit" id="submitContact" class="btn btn-primary">Gửi đi</button>
				</div>
				{{Form::close()}}
			</div>
		</div>
		@if(isset($arrBannerRight) && sizeof($arrBannerRight) > 0)
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