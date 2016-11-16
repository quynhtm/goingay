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
				<div class="box-content-info-32">
					<ul>
						<li>
							<a href="">Tài khoản</a>
							<div class="t2">
								<a href="" class="active">Thông tin cá nhân</a>
							</div>
						</li>
						<li>
							<a href="javascript:void(0);">Danh sách tin</a>
							<div class="t2">
								<a href="" class="">Tin đã đăng</a>
								<a href="" class="">in lưu trữ</a>
							</div>
						</li>
					</ul>
				</div>
				<div class="box-content-info-65">
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
									<p>Email<span class="required" aria-required="true">*</span></p>
									<input name="customer_email" value="@if(isset($user_customer['customer_email'])){{$user_customer['customer_email']}}@endif" placeholder="Nhập vào địa chỉ email" disabled class="upload_input" type="text">
								</div>
								<div class="box-item-455 ext">
									<div class="mail-show">
										<input name="customer_show_email" value="@if(isset($user_customer['customer_show_email'])){{$user_customer['customer_show_email']}}@endif" @if(isset($user_customer['customer_show_email']) && $user_customer['customer_show_email'] == 1)checked @endif class="checkbox" type="checkbox">
										<span class="hien_email">Hiển thị</span>
									</div>
								</div>
							</div>
							<div class="line">
								<div class="box-item-455 unit">
									<p>Tỉnh/Thành: <span class="required">*</span></p>
									<select class="select_s" name="customer_province_id">
										<option value="">Chọn tỉnh/Thành</option>
									</select>
								</div>
								<div class="box-item-455 unit">
									<p>Quận/huyện: <span class="required">*</span></p>
									<select class="select_s" name="customer_district_id">
										<option value="">Chọn quận/huyện</option>
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
										<option value="Nam">Nam</option>
										<option value="Nữ">Nữ</option>
									</select>
								</div>
								<div class="box-item-455 born">
									<p>Ngày sinh: </p>
									<input name="customer_birthday" placeholder="dd/mm/yyyy" value="" autocomplete="off" type="text">
								</div>
							</div>
							<div class="line">
								<p>Thời gian liên hệ tốt nhất</p>
								<input name="customer_about" value="@if(isset($user_customer['customer_address'])){{$user_customer['customer_address']}}@endif"type="text">
							</div>
							<div class="line">
								<button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Cập nhật</button>
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
			@endif
		</div>
		<div class="col-right-16">
			<div class="box-ads">
				<img src="http://static.eclick.vn/uploads/source/2016/10/25/407950308217385024l37352a45.jpeg">
			</div>
		</div>
	</div>
</div>