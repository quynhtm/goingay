<div class="search-box">
	<div class="wrapp-search-box">
		<div class="search-box-title">Thông tin tìm kiếm</div>
		{{Form::open(array('method' => 'GET', 'id'=>'frmSearch', 'class'=>'frmSearch', 'name'=>'frmSearch'))}}
			<div class="row">
				<div class="col-lg-2">
					<label class="control-label">Tên đăng nhập</label>
					<div>
						<input type="text" class="form-control input-sm" id="user_name" name="user_name" autocomplete="off" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
					</div>
				</div>
				<div class="col-lg-2">
					<label class="control-label">Email</label>
					<div>
						 <input type="text" class="form-control input-sm" id="user_email" name="user_email" autocomplete="off" placeholder="Địa chỉ email" @if(isset($dataSearch['user_email']))value="{{$dataSearch['user_email']}}"@endif>
					</div>
				</div>
				<div class="col-lg-2">
					<label class="control-label">Điện thoại</label>
					<div>
						 <input type="text" class="form-control input-sm" id="user_phone" name="user_phone" autocomplete="off" placeholder="Số di động" @if(isset($dataSearch['user_phone']))value="{{$dataSearch['user_phone']}}"@endif>
					</div>
				</div>
				<div class="col-lg-2">
					<label class="control-label">Nhóm quyền</label>
					<div>
						<select name="user_group" id="user_group" class="form-control input-sm" tabindex="12" data-placeholder="Chọn nhóm quyền">
                             <option value="0">--- Chọn nhóm quyền ---</option>
                             @foreach($arrGroupUser as $k => $v)
                             <option value="{{$k}}" @if($dataSearch['user_group'] == $k) selected="selected" @endif>{{$v}}</option>
                            @endforeach
                       </select>
					</div>
				</div>
				<div class="col-lg-2">
					<label class="control-label">&nbsp;</label>
					<div><button class="btn btn-primary" name="submit" value="s">Tìm kiếm</button></div>
				</div>
			</div>
		{{Form::close()}}
	</div>
</div>
<div class="inner-box">
	<div class="page-title-box">
		<h5 class="padding10">Quản lý thông tin chung</h5>
		<span class="menu_tools">
			<a href="{{URL::route('admin.user_create')}}" title="Thêm mới" class="fa fa-plus fa-admin green"></a>
	    </span>
	</div>
	<div class="page-content-box">
		@if($size>0)
		<div class="show-bottom-info">
			<div class="total-rows">Tổng số: {{$size}}</div>
			<div class="list-item-page">
				<div class="showListPage">{{$paging}}</div>
			</div>
		</div>
		@endif
		
		<div class="showListItem">
			<table width="100%" cellspacing="1" cellpadding="5" border="1">
				<thead>
					<tr>
						<th width="5%">STT</th>
						<th width="40%">Thông tin</th>
						<th width="15%">Ngày tạo</th>
						<th width="20%">Thao tác</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($data as $key => $item)
					<tr @if($item['user_status'] == -1)class="red bg-danger" @endif>
						<td class="text-center">{{ $start+$key+1 }}</td>
						<td>
							<div class="green"><b>Tài khoản : </b>{{ $item['user_name'] }}</div>
							<div><b>Tên nhân viên : </b>{{ $item['user_full_name'] }}</div>
							<div><b>Số điện thoại : </b>{{ $item['user_phone'] }}</div>
							<div><b>Email : </b>{{ $item['user_email'] }}</div>
						</td>
						<td class="text-center">
							@if($item['user_created'])
								{{ date("d-m-Y",$item['user_created']) }}
							@endif
						</td>
						<td class="text-center" align="center">
							<br/>
							@if($permission_edit)
								<a href="{{URL::route('admin.user_edit',array('id' => $item['user_id']))}}" class="btn btn-xs btn-primary" data-content="Sửa thông tin tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover">
									<i class="ace-icon fa fa-edit bigger-120"></i>
								</a>
							@endif
							@if($permission_change_pass)
								<a href="{{URL::route('admin.user_change',array('id' => base64_encode($item['user_id'])))}}" class="btn btn-xs btn-success" data-content="Đổi mật khẩu" data-placement="bottom" data-trigger="hover" data-rel="popover">
									<i class="ace-icon fa fa-unlock bigger-120"></i>
								</a>
							@endif
							@if($permission_remove)
								<a href="javascript:void(0)" class="btn btn-xs btn-danger sys_delete_user" data-content="Xóa tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover" data-id="{{$item['user_id']}}">
									<i class="ace-icon fa fa-trash-o bigger-120"></i>
								</a>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@if($size>0)
		<div class="show-bottom-info">
			<div class="total-rows">Tổng số: {{$size}}</div>
			<div class="list-item-page">
				<div class="showListPage">{{$paging}}</div>
			</div>
		</div>
		@endif
	</div>
</div>	
{{HTML::script('assets/backend/js/user.js');}}
<script type="text/javascript">
    $('[data-rel=popover]').popover({container: 'body'});
</script>