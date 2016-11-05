<div class="page-login">
	<div class="wrapp-page-login">
		<div class="box-title-login">
			<span class="cms">CMS</span>
			<span class="white">Control Panel</span>
			<div class="copyright">&copy; @if(CGlobal::web_name){{ucwords(CGlobal::web_name)}}@endif</div>
		</div>	
		<div class="box-login">
			<div class="form-login">
				{{ Form::open(array('class'=>'formSendLogin')) }}
					<div class="line-title-form">
						<i class="login-icon icon-coffee"></i> Vui lòng nhập thông tin
					</div>
					@if(isset($error))
						<div class="alert alert-danger">{{$error}}</div>
					@endif
					<div class="form-group">
						<div class="item-line">
							<input type="text" class="form-control" name="user_name" placeholder="Tên đăng nhập"  @if(isset($username)) value="{{$username}}" @endif/>
						</div>
					</div>
					<div class="form-group">
						<div class="item-line">
							<input type="password" class="form-control" name="user_password" placeholder="Mật khẩu" />
						</div>
					</div>
					
					<button type="submit" class="btn btn-primary btnLogin">
						<span class="txt-login">Đăng nhập</span>
					</button>
					<a rel="nofollow" href="javascript:void(0)" class="forgotpass">Bạn quên mật khẩu?</a>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>