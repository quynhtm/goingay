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
				<th width="55%">Thông tin</th>
				<th width="16%" class="text-center">Ngày thao tác</th>
				<th width="17%" class="text-center">Thao tác</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($data as $key => $item)
				<tr>
					<td class="text-center text-middle">
						<img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item->item_id, $item->item_image, CGlobal::sizeImage_100)}}">
					</td>
					<td>[<b>{{ $item->item_id }}</b>] {{ $item->item_name }}</td>
					<td class="text-center text-middle">
						<span style="font-size: 9px;color: green">Top: {{ date('d-m-Y h:i',$item->time_ontop) }}</span>
						<div class="clear"></div>
						<span style="font-size: 9px;">U: {{ date('d-m-Y h:i',$item->time_update) }}</span>
					</td>
					<td class="text-center text-middle">
						@if($item->item_status == CGlobal::status_show)
							<a href="javascript:void(0);" style="color: green" title="Hiện thị"><i class="fa fa-check fa-2x"></i></a>
						@else
							<a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
						@endif
							&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" style="color: red" onclick="USER_CUSTOMMER.removeItems({{$item->item_id}});" title="Xóa tin đăng"><i class="fa fa-trash fa-2x"></i></a>
						<br/><a href="{{URL::route('customer.ItemsEdit',array('item_id' => $item->item_id))}}" title="Sửa tin đăng"><i class="fa fa-edit fa-2x"></i></a>
						&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="USER_CUSTOMMER.setTopItems({{$item->item_id}});" title="Up top tin đăng"><i class="fa fa-level-up fa-2x"></i></a>

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
	@if(sizeof($arrBannerRight) > 0)
	<div class="box-ads">
		<ul class="rslides" id="sliderRight">
			@foreach($arrBannerRight as $slider)
			<?php 
			if($slider->banner_is_rel == 0){
				$rel = 'rel="nofollow"';
			}else{
				$rel = '';
			}
			if($slider->banner_is_target == 0){
				$target = 'target="_blank"';
			}else{
				$target = '';
			}
			
			$banner_is_run_time = 1;
			if($slider->banner_is_run_time == CGlobal::status_hide){
				$banner_is_run_time = 1;
			}else{
				$banner_start_time = $slider->banner_start_time;
				$banner_end_time = $slider->banner_end_time;
				$date_current = time();
			
				if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
					if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
						$banner_is_run_time = 1;
					}
				}else{
					$banner_is_run_time = 0;
				}
			}
			?>
			@if($banner_is_run_time == 1)
			<div class="slide ">
				<a {{$target}} {{$rel}} href="@if($slider->banner_link != '') {{$slider->banner_link}} @else javascript:void(0) @endif" title="{{$slider->banner_name}}">
					<img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_BANNER, $slider->banner_id, $slider->banner_image, 200, 600, '', true, true, false)}}" alt="{{$slider->banner_name}}" />
				</a>
			</div>
			@endif
			@endforeach
		 </ul>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#sliderRight").responsiveSlides({
				    maxwidth: 1000,
				    speed: 800,
				    timeout: 10000,
			    });
			});
		</script>
	</div>
	@endif
</div>
