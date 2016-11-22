@if(Route::currentRouteName() == 'site.home')
<!-- Home Page -->
<div class="col-left-200">
	<ul class="box-menu-category">
		<li>
			<a href="/" class="act"><i class="fa fa-home"></i>Trang chủ</a>
		</li>
		<li>
			<a href=""><i class="fa fa-building"></i> Mua bán nhà đất </a>
		</li>
		<li>
			<a href=""><i class="fa fa-building-o"></i> Thuê nhà đất </a>
		</li>
		<li>
			<a href=""><i class="fa fa-car"></i> Ôtô </a>
		</li>
		<li>
			<a href=""><i class="fa fa-bicycle"></i> Xe máy - Xe đạp </a>
		</li>
		<li>
			<a href=""><i class="fa fa-mortar-board"></i> Tuyển sinh - Tuyển dụng </a>
		</li>
		<li>
			<a href="/dien-thoai-sim"><i class="fa fa-mobile-phone"></i> Điện thoại - Sim </a>
		</li>
		<li>
			<a href="/pc-laptop"><i class="fa fa-laptop"></i> PC - Laptop </a>
		</li>
		<li>
			<a href="/dien-tu-ky-thuat-so"><i class="fa fa-desktop"></i> Điện tử - Kỹ thuật số </a>
		</li>
		<li>
			<a href="/thoi-trang-lam-dep"><i class="fa fa-child"></i> Thời trang - Làm đẹp </a>
		</li>
		<li>
			<a href="/am-thuc-du-lich"><i class="fa fa-cutlery"></i> Ẩm thực - Du lịch </a>
		</li>
		<li>
			<a href="/dich-vu"><i class="fa fa-dropbox"></i> Dịch vụ </a>
		</li>
		<li>
			<a href="/khac"><i class="fa fa-asterisk"></i> Khác </a>
		</li>
	</ul>
	<div class="box-ads">
		<img src="http://static.eclick.vn/uploads/source/2016/10/25/407950308217385024l37352a45.jpeg">
	</div>
</div>
@else
<!-- Other Page -->
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
@endif