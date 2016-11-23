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
				<h2><a href=""><i class="fa fa-location-arrow"></i> Danh sách tin đăng</a></h2>
			</div>
			<div class="panel panel-info">
				{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
				<div class="panel-body">
					<div class="form-group col-lg-6">
						<label for="item_name">Title tin đăng</label>
						<input type="text" class="form-control input-sm" id="item_name" name="item_name" placeholder="Tiêu đề tin tức" @if(isset($search['item_name']) && $search['item_name'] != '')value="{{$search['item_name']}}"@endif>
					</div>
					<div class="form-group col-lg-3">
						<label for="item_status">Trạng thái</label>
						<select name="item_status" id="item_status" class="form-control input-sm">
							{{$optionStatus}}
						</select>
					</div>
					<div class="form-group col-lg-3">
						<label for="item_category_id">Danh mục</label>
						<select name="item_category_id" id="item_category_id" class="form-control input-sm">
							{{$optionCategory}}
						</select>
					</div>
					<div class="form-group col-lg-12 text-right">
						<span class="">
						<a class="btn btn-danger btn-sm" href="{{URL::route('customer.ItemsAdd')}}">
							<i class="ace-icon fa fa-plus-circle"></i>
							Đăng tin
						</a>
						</span>
						<span class="">
							<button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
						</span>
					</div>
				</div>
				{{ Form::close() }}
			</div>
			@if(isset($data) && !empty($data))
			<div class="content-info">
				<div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> tin đăng @endif </div>
				<br>
				<table class="table table-bordered table-hover">
					<thead class="thin-border-bottom">
					<tr class="">
						<th width="10%" class="text-center">Ảnh</th>
						<th width="45%">Thông tin</th>
						<th width="13%" class="text-center">Ngày </th>
						<th width="5%" class="text-center">Ẩn/hiện</th>
						<th width="15%" class="text-center">Thao tác</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($data as $key => $item)
						<tr>
							<td class="text-center text-middle">
								<img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item->item_id, $item->item_image, CGlobal::sizeImage_100)}}">
							</td>
							<td>[<b>{{ $item->item_id }}</b>] {{ $item->item_name }}</td>
							<td class="text-center text-middle">{{ date('d-m-Y',$item->time_created) }}</td>
							<td class="text-center">
								@if($item->item_status == CGlobal::status_show)
									<a href="javascript:void(0);" style="color: green" title="Hiện thị"><i class="fa fa-check fa-2x"></i></a>
								@else
									<a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
								@endif
							</td>
							<td class="text-center text-middle">
								<a href="{{URL::route('customer.ItemsEdit',array('item_id' => $item->item_id))}}" title="Sửa tin đăng"><i class="fa fa-edit fa-2x"></i></a>
								&nbsp;&nbsp;&nbsp;<a href="{{URL::route('customer.ItemsEdit',array('item_id' => $item->item_id))}}" title="Up top tin đăng"><i class="fa fa-level-up fa-2x"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				<div class="text-right">
					{{$paging}}
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