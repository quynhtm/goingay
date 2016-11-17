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
			@if(isset($data) && !empty($data))
			<div class="content-info">
				<table class="table table-bordered table-hover">
					<thead class="thin-border-bottom">
					<tr class="">
						<th width="2%" class="text-center">STT</th>
						<th width="10%" class="text-center">Ảnh</th>
						<th width="66%">Thông tin</th>
						<th width="12%" class="text-center">Ngày </th>
						<th width="10%" class="text-center"></th>
					</tr>
					</thead>
					<tbody>
					@foreach ($data as $key => $item)
						<tr>
							<td class="text-center text-middle">{{ $stt + $key+1 }}</td>
							<td class="text-center text-middle">
								<img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item->item_id, $item->item_image, CGlobal::sizeImage_100)}}">
							</td>
							<td>[<b>{{ $item->item_id }}</b>] {{ $item->item_name }}</td>
							<td class="text-center text-middle">{{ date('d-m-Y',$item->time_created) }}</td>
							<td class="text-center text-middle">
								<a href="{{URL::route('customer.ItemsEdit',array('item_id' => $item->item_id))}}" title="Sửa tin đăng"><i class="fa fa-edit fa-2x"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
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