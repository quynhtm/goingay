<div class="line-footer">
	<div class="container">
		<div class="box-footer">
			<div class="box-60">
				<div class="address">
					{{$address}}
				</div>
			</div>
			<div class="box-40">
				<div class="percent-45">
					<div class="f-title">
						<a hreft="">Quy chế về tin đăng</a>
					</div>
					<ul class="f-box-link">
						<li><a href="{{URL::route('site.home')}}/chi-tiet/tin-tuc-1/quy-che-dang-tin.html" title="Quy chế đăng tin">Quy chế đăng tin</a></li>
						<li><a href="{{URL::route('site.home')}}/chi-tiet/tin-tuc-2/chinh-sach-bao-mat.html" title="Chính sách bảo mật">Chính sách bảo mật</a></li>
						<li><a href="{{URL::route('site.pageContact')}}">Quy trình giải quyết khiếu nại</a></li>
						<li><a href="{{URL::route('site.pageContact')}}">Quy trình thanh toán</a></li>
					</ul>
				</div>
				<div class="percent-45">
					<div class="f-title">
						<a hreft="">Quy chế hoạt động</a>
					</div>
					<ul class="f-box-link">
						<li><a href="{{URL::route('site.pageContact')}}" target="_blank" title="Giới thiệu">Giới thiệu</a></li>
						<li><a href="http://raovat30s.vn/chi-tiet/tin-tuc-3/huong-dan-dang-ky-account-dang-tin-tren-raovat30s-vn.html" title="Hỗ trợ">Hướng dẫn đăng ký</a></li>
						<li><a href="{{URL::route('site.pageContact')}}" target="_blank" title="Bảng giá quảng cáo">Bảng giá quảng cáo</a></li>
						<li><a href="{{URL::route('site.pageContact')}}" title="Liên hệ">Liên hệ</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>	
</div>
<span id="back-top"></span>
<div class="icon-pin">
	<ul>
		<!--<li><a class="pin icon-post" href="">Post</a></li>-->
		<li><a class="pin icon-contact" href="{{URL::route('site.pageContact')}}" title="Liên hệ với quản trị {{CGlobal::web_name}}">Contact</a></li>
	</ul>
</div>