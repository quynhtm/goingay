<div class="main-view-post box-reg-login loginbox">
    <div class="form-login">
        <h1 class="title-head">Đăng nhập <span>/</span> <a href="{{URL::route('site.shopRegister')}}" class="link-tab" rel="nofollow" >Đăng ký mở gian hàng</a></h1>
            @if(isset($error) && $error != '')
                <div class="line-error">{{$error}}</div>
            @endif
           {{ Form::open(array('class'=>'formSendLogin','method' => 'POST','url' =>"dang-nhap.html")) }}
            <div class="form-group">
                <label class="control-label">Tên đăng nhập<span>(*)</span></label>
                <input type="text" id="user_shop_login" class="form-control" name="user_shop_login">
            </div>
            <div class="form-group">
                <label class="control-label">Mật khẩu<span>(*)</span></label>
                <input type="password" id="password_shop_login" class="form-control" name="password_shop_login">
            </div>
            <button type="submit" id="submitLogin" class="btn btn-primary">Đăng nhập</button>
            <a class="forgotpass" href="{{URL::route('site.shopForgetPass')}}" rel="nofollow">Bạn quên mật khẩu?</a>
        {{ Form::close() }}
    </div>
</div>