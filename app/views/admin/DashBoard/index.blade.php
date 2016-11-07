<div class="wrapper-admin-cpanel">
	<div class="notification-global">Quản trị nội dung website {{CGlobal::web_name}}</div>
	<div class="content-global">
		@if(isset($error) && !empty($error))
			<div class="alert alert-danger" role="alert">
				@foreach($error as $itmError)
					<p>{{ $itmError }}</p>
				@endforeach
			</div>
		@endif
		@if(!empty($menu))
		    @foreach($menu as $item)
				@if(isset($item['sub']) && !empty($item['sub']))
					@foreach($item['sub'] as $sub)
					@if(isset($sub['showcontent']) && $sub['showcontent'] == 1)
					<div class="col-lg-2 text-center">
						<a href="{{ $sub['link'] }}">
							<div class="boder-item padding10">
								<i class="{{ $sub['icon'] }}"></i><br>{{ $sub['name'] }}
							</div>
						</a>
					</div>
					@endif
					@if(isset($sub['clear']) && $sub['clear'] == 1)
						<div class="clear"></div>
					@endif
					@endforeach
				@endif
			@endforeach
        @endif
	</div>
</div>