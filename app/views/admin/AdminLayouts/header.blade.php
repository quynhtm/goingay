<div class="headerRegion">
	<div class="list-menu-header">
		<nav class="navbar navbar-inverse">
			<a href="{{URL::route('site.home')}}" class="logo" target="_blank"></a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Menu icon</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul clas="navigation nav navbar-nav menu-header">
			        <li>
			        	<a href="{{URL::route('admin.dashboard')}}">Trang chủ quản trị</a>
			        </li>
			        @if(!empty($menu))
			        @foreach($menu as $item)
			        <li>
			            <a href="{{ $item['link'] }}">{{ $item['name'] }}<i class="{{ $item['icon'] }}"></i></a>
			            @if(isset($item['sub']) && !empty($item['sub']))
			            <ul class="sub">
			                @foreach($item['sub'] as $sub)
			                <li><a href="{{ $sub['link'] }}"><i class="icon"></i>{{ $sub['name'] }}</a></li>
			                @endforeach
			            </ul>
			            @endif
			        </li>
			       @endforeach
			       @endif
			    </ul>
			 </div>
		</nav>
	</div>
	<a class="user-logout" href="{{URL::route('admin.logout')}}" title="logout"><i class="fa fa-sign-out"></i></a>
	<div class="user-info">
		<span class="name-user">Chào: {{isset($user['user_full_name']) ? $user['user_full_name'] : 'No Name'}}</span>
	</div>
</div>