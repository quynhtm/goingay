<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý Website Hostting</li>
		</ul><!-- /.breadcrumb -->
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="panel panel-info">
					{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
					<div class="panel-body">
						<div class="form-group col-lg-3">
							<label for="web_id">Web ID</label>
							<input type="text" class="form-control input-sm" id="web_id" name="web_id" placeholder="ID website" @if(isset($search['web_id']) && $search['web_id'] > 0)value="{{$search['web_id']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="web_name">Name site</label>
							<input type="text" class="form-control input-sm" id="web_name" name="web_name" placeholder="Tên website" @if(isset($search['web_name']) && $search['web_name'] != '')value="{{$search['web_name']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="web_domain">Domain</label>
							<input type="text" class="form-control input-sm" id="web_domain" name="web_domain" placeholder="Domain" @if(isset($search['web_domain']) && $search['web_domain'] != '')value="{{$search['web_domain']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="web_status">Trạng thái</label>
							<select name="web_status" id="web_status" class="form-control input-sm">
								{{$optionStatus}}
							</select>
						</div>
						<div class="form-group col-lg-3">
							<label for="object_name">Ngày từ</label>
							<input type="text" class="form-control" id="start_time" name="start_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['start_time']) && $search['start_time'] > 0){{date('d-m-Y',$search['start_time'])}}@endif">
						</div>
						<div class="form-group col-lg-3">
							<label for="object_name">đến</label>
							<input type="text" class="form-control" id="end_time" name="end_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['end_time']) && $search['end_time'] > 0){{date('d-m-Y',$search['end_time'])}}@endif">
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root || $permission_full ==1 || $permission_create == 1)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.hosttingEdit')}}">
								<i class="ace-icon fa fa-plus-circle"></i>
								Thêm mới
							</a>
                        </span>
						@endif
						<span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
					</div>
					{{ Form::close() }}
				</div>
				@if(sizeof($data) > 0)
					<div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
					<br>
					<table class="table table-bordered table-hover">
						<thead class="thin-border-bottom">
						<tr class="">
							<th width="5%" class="text-center">STT</th>
							<th width="20%">Tên website</th>
							<th width="30%">Thông tin thêm</th>
							<th width="25%">Ghi chú</th>
							<th width="10%" class="text-center">Thời gian chạy</th>
							<th width="10%" class="text-center"></th>
						</tr>
						</thead>
						<tbody>
						@foreach ($data as $key => $item)
							<tr>
								<td class="text-center text-middle">{{ $stt + $key+1 }}</td>
								<td>
									[<b>{{ $item['web_id'] }}</b>] {{ $item['web_name'] }}
									@if($item->web_price > 0)
										<br/><b>Giá:</b> <b class="red">{{ FunctionLib::numberFormat($item->web_price) }} đ</b>
									@endif
								</td>
								<td>
									@if($item['web_infor'] !='')
										<?php $web_infor = unserialize($item['web_infor']);?>
										<b>N: </b>{{$web_infor['infor_name']}}<br/>
										<b>S: </b>{{$web_infor['infor_stand']}}<br/>
										<b>C: </b>{{$web_infor['infor_bank_code']}}<br/>
										<b>B: </b>{{$web_infor['infor_bank_address']}}<br/>
										<b>E: </b>{{$web_infor['infor_email']}}<br/>
										<b>F: </b>{{$web_infor['infor_phone']}}<br/>
										<b>A: </b>{{$web_infor['infor_address']}}<br/>
									@endif
								</td>
								<td>{{ $item['web_note'] }}</td>
								<td class="text-center text-middle">
									<b style="color: green">{{date('d-m-Y',$item->web_time_start)}}</b>
									<br/><b style="color: red">{{date('d-m-Y',$item->web_time_end)}}</b>
								</td>
								<td class="text-center text-middle">
									@if($item['web_status'] == 1)
										<a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
									@else
										<a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
									@endif
									@if($is_root || $permission_full ==1|| $permission_edit ==1  )
										&nbsp;&nbsp;&nbsp;<a href="{{URL::route('admin.hosttingEdit',array('id' => $item['web_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['web_id']}}"></span>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					<div class="text-right">
						{{$paging}}
					</div>
				@else
					<div class="alert">
						Không có dữ liệu
					</div>
					@endif
			</div>
		</div>
	</div><!-- /.page-content -->
</div>
<script>
	$(document).ready(function(){
		var checkin = $('#start_time').datepicker({ });
		var checkout = $('#end_time').datepicker({ });
	});
</script>