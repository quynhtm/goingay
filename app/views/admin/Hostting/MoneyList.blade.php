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
							<label for="money_name">Name site</label>
							<input type="text" class="form-control input-sm" id="money_name" name="money_name" placeholder="Tên website" @if(isset($search['money_name']) && $search['money_name'] != '')value="{{$search['money_name']}}"@endif>
						</div>
						<div class="form-group col-lg-3">
							<label for="web_status">Kiểu xuất - nhập</label>
							<select name="money_type" id="money_type" class="form-control input-sm">
								{{$optionType}}
							</select>
						</div>
						<div class="form-group col-lg-3">
							<label for="object_name">Ngày tạo từ</label>
							<input type="text" class="form-control" id="start_time" name="start_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['start_time']) && $search['start_time'] > 0){{date('d-m-Y',$search['start_time'])}}@endif">
						</div>
						<div class="form-group col-lg-3">
							<label for="object_name">đến</label>
							<input type="text" class="form-control" id="end_time" name="end_time"  data-date-format="dd-mm-yyyy" value="@if(isset($search['end_time']) && $search['end_time'] > 0){{date('d-m-Y',$search['end_time'])}}@endif">
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.managerMoneyEdit')}}">
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
							<th width="20%">Lý do </th>
							<th width="10%">Kiểu</th>
							<th width="12%" class="text-right">Số tiền</th>
							<th width="12%" class="text-right">Tiền còn lại</th>
							<th width="25%">Ghi chú</th>
							<th width="20%" class="text-center">Thời gian</th>
							<th width="10%" class="text-center"></th>
						</tr>
						</thead>
						<tbody>
						@foreach ($data as $key => $item)
							<tr>
								<td class="text-center text-middle">{{ $stt + $key+1 }}</td>
								<td>{{$item->money_name}}</td>
								<td>
									@if(isset($arrType[$item->money_type]))
										<b @if($item->money_type == 1) class="green" @else class="red" @endif>{{$arrType[$item->money_type]}}</b>
									@else --- @endif
								</td>
								<td class="text-right">
									@if($item->money_price > 0)
										<b>{{ FunctionLib::numberFormat($item->money_price) }}đ</b><br/>
									@endif
								</td>
								<td class="text-right">
									@if($item->money_total_price > 0)
										<b @if($item->money_type == 1) class="green" @else class="red" @endif>{{ FunctionLib::numberFormat($item->money_total_price) }}đ</b><br/>
									@endif
								</td>
								<td>{{$item->money_infor}}</td>
								<td class="text-center">
									@if($item->money_time_creater > 0)Tạo: {{date('d-m-Y H:i:s',$item->money_time_creater)}}@endif
									@if($item->money_time_update > 0)<br/>Sửa: {{date('d-m-Y H:i:s',$item->money_time_update)}}@endif
								</td>
								<td class="text-center text-middle">
									@if($is_root || $permission_full ==1|| $permission_edit ==1  )
										<a href="{{URL::route('admin.managerMoneyEdit',array('id' => $item['money_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['money_id']}}"></span>
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
		var checkin2 = $('#start_time').datepicker({ });
		var checkout2 = $('#end_time').datepicker({ });
	});
</script>