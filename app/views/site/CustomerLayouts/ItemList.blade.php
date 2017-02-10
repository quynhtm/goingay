<div class="col-left-92">
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
				<label for="item_status">Loại tin đăng</label>
				<select name="item_type_action" id="item_type_action" class="form-control input-sm">
					{{$optionTypeAction}}
				</select>
			</div>
			<div class="form-group col-lg-3">
				<label for="item_category_id">Danh mục</label>
				<select name="item_category_id" id="item_category_id" class="form-control input-sm">
					{{$optionCategory}}
				</select>
			</div>
			<div class="form-group col-lg-9 text-right padding-10">
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
				<th width="8%" class="text-center">Ảnh</th>
				<th width="45%">Thông tin</th>
				<th width="16%" class="text-right">Giá bán</th>
				<th width="12%" class="text-center">Ngày thao tác</th>
				<th width="10%" class="text-center">Chia sẻ</th>
				<th width="17%" class="text-center">Thao tác</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($data as $key => $item)
				<tr>
					<td class="text-center text-middle">
						@if($item->item_status == CGlobal::status_show)
							<a href="{{FunctionLib::buildLinkDetailItem($item->item_id,$item->item_name,$item->item_category_id)}}" title="Chi tiết tin đăng" target="_blank">
								<img height="40" src="{{ ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item->item_id,$item->item_category_id, $item->item_image, CGlobal::sizeImage_100)}}">
							</a>
						@else
							<img height="40" src="{{ ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item->item_id,$item->item_category_id, $item->item_image, CGlobal::sizeImage_100)}}">
						@endif
					</td>
					<td>
						[<b>{{ $item->item_id }}</b>]
						@if($item->item_status == CGlobal::status_show)
							<a href="{{FunctionLib::buildLinkDetailItem($item->item_id,$item->item_name,$item->item_category_id)}}" title="Chi tiết tin đăng" target="_blank" style="text-decoration: underline">{{ $item->item_name }}</a>
						@else
							{{ $item->item_name }}
						@endif
						@if($item->item_category_name != '')<br/><b>Mục tin: </b>{{ $item->item_category_name }}@endif
						@if(isset($arrTypeAction[$item->item_type_action]))
							<br/><b @if($item->item_type_action == CGlobal::ITEMS_TYPE_ACTION_1) style="color: red!important;" @else style="color: green!important;" @endif>{{ $arrTypeAction[$item->item_type_action] }}</b>
						@endif
					</td>
					<td class="text-right">
						@if($item->item_type_price == CGlobal::TYPE_PRICE_NUMBER)
							<b style="color: red">{{FunctionLib::numberFormat($item->item_price_sell)}} đ</b>
						@else
							<b style="color: red">Liên hệ</b>
						@endif
					</td>
					<td class="text-center text-middle">
						<span style="font-size: 9px;color: green">Top: {{ date('d-m-Y h:i',$item->time_ontop) }}</span>
						<div class="clear"></div>
						<span style="font-size: 9px;">U: {{ date('d-m-Y h:i',$item->time_update) }}</span>
					</td>
					<td>
						<?php 
						$url_link_share = FunctionLib::buildLinkDetailItem($item->item_id,$item->item_name,$item->item_category_id);
						if(!empty($arrCustomer)){
							$string_base = $arrCustomer->customer_id.'_'.$arrCustomer->customer_email;
							$param_customer_share = '?customer_share='.base64_encode($string_base);
							$url_link_share .= $param_customer_share;
						}
						?>
						<div class="like-social text-center">
							<a class="share-google" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên google" data-url="{{$url_link_share}}">
								<i  class="icon-share fa fa-google-plus"></i>
							</a>
							<a class="share-facebook" rel="nofollow" href="javascript:void(0);" title="Chia sẻ bài viết lên facebook" data-url="{{$url_link_share}}">
								<i class="icon-share fa fa-facebook"></i>
							</a>
						</div>
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

<!--Popup đặt lịch-->
<div class="modal fade" id="sys_PopupSetTimeUpDeal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 1000px">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_ajax">
				{{ Form::open(array('class'=>'form-horizontal','id'=>'form_uptime')) }}
				<div class="form_group">
					<div class="clearfix" style='margin: 5px; 10px; width:100%;'>
						<div id="sys_msg_return" style="color: red; font-weight: bold"></div>
						<div id="sys_infor_popup" class="clearfix" style="display: none">

							<div class="float-left marginTop20" style="width: 100%; padding-bottom: 10px; border-bottom: 1px dotted #ccc">
								<div class="float-left">
									<span style="font-weight: bold">Đặt lịch tự động</span>
								</div>
								<div class="float-right text-right">
                                    <span class="control-label font_normal" id="sys_name_deal_up"><span>
								</div>
							</div>
							<div class="clear "></div>
							<div id="infor_left" style="float: left; width: 60%" class="marginTop20">
								<!--Block 1-->
								<div class="col-lg-12">
									<label for="TestForm_textField" class="control-label">Chọn ngày trong tuần</label>
								</div>
								<div class="col-lg-12 marginLeft20 marginTop10">
									<div class="float-left">
										<input type="checkbox" id="thu_2" name="thu_2" class="float-left" value="0" > <label for="thu_2" class="float-left font_normal">&nbsp;Thứ 2</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_3" name="thu_3" class="float-left" value="0"> <label for="thu_3" class="float-left font_normal">&nbsp;Thứ 3</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_4" name="thu_4" class="float-left" value="0"> <label for="thu_4" class="float-left font_normal">&nbsp;Thứ 4</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_5" name="thu_5" class="float-left" value="0"> <label for="thu_5" class="float-left font_normal">&nbsp;Thứ 5</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_6" name="thu_6" class="float-left" value="0"> <label for="thu_6" class="float-left font_normal">&nbsp;Thứ 6</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_7" name="thu_7" class="float-left" value="0"> <label for="thu_7" class="float-left font_normal">&nbsp;Thứ 7</label>
									</div>
									<div class="float-left marginLeft10">
										<input type="checkbox" id="thu_8" name="thu_8" class="float-left" value="0"> <label for="thu_8" class="float-left font_normal">&nbsp;Chủ nhật</label>
									</div>
								</div>

								<!--Block 2-->
								<div class="clear"></div>
								<div class="col-lg-12 marginTop10">
									<label for="TestForm_textField" class="control-label">Số lần up tin</label>
								</div>
								<div class="col-lg-12 marginLeft20 marginTop10">
									<div class="float-left width100">
										<span class="float-left width30"><i class="fa fa-clock-o"></i> Từ 0h00 đến 5h 59</span>
										<input type="text" id="number_up_1" name="number_up_1" class="float-left" value="0" size="5">
									</div>
									<div class="clear"></div>
									<div class=" float-left width100 marginTop10">
										<span class="float-left width30"><i class="fa fa-clock-o"></i> Từ 6h00 đến 11h59</span>
										<input type="text" id="number_up_2" name="number_up_2" class="float-left" value="0" size="5">
									</div>
									<div class="clear"></div>
									<div class=" float-left width100 marginTop10">
										<span class="float-left width30"><i class="fa fa-clock-o"></i> Từ 12h00 đến 17h59 &nbsp;&nbsp;</span>
										<input type="text" id="number_up_3" name="number_up_3" class="float-left" value="0" size="5">
									</div>
									<div class="clear"></div>
									<div class=" float-left width100 marginTop10">
										<span class="float-left width30"><i class="fa fa-clock-o"></i> Từ 18h00 đến 23h59 &nbsp;&nbsp;</span>
										<input type="text" id="number_up_4" name="number_up_4" class="float-left" value="0" size="5">
									</div>
									<div class="clear"></div>
									<div class="float-left marginTop10">
										<a href="javascript:;" class="btn btn-primary" onclick="Product.setUpTime()">Tự động lập lại lịch</a>
									</div>
								</div>
							</div>

							<!--Block ben phai-->
							<div id="infor_right" class="float-right marginTop20" style="width: 40%;">

								<div class="float-right" style="border: 2px solid #ccc; width: 100%; padding: 10px 0px;">
									<div class="col-lg-12">
										<span class="float-left">Tài khoản của bạn còn</span>
										<span class="float-right text-center" style="width: 50px"><b id="sys_number_up_shop"></b> <br/>lượt</span>
										<input type="hidden" id="sys_number_up_can_user_shop" name="sys_number_up_can_user_shop" value="0"/>
									</div>

									<div class="clear"></div>
									<div class="col-lg-12">
										<span class="float-left">Tổng số lượt dùng cho deal này</span>
										<span class="float-right text-center"><input type="text" id="number_up_hold" name="number_up_hold" value="0" size="3" style="text-align: center"><br/>lượt</span>
									</div>

									<div class="clear"></div>
									<div class="col-lg-12">
										<span class="float-left">Số lượt up còn lại của deal</span>
										<span class="float-right text-center" style="width: 50px"><b id="hold_con_lai"></b><br/>lượt</span>
										<input type="hidden" id="sys_hidden_hold_con_lai" name="sys_hidden_hold_con_lai" value="0"/>
									</div>
								</div>
							</div>

							<div class="clear"></div>
							<!--Block time-->
							<div class="float-left marginTop20" style="width: 100%">

								<div class="clear"></div>
								<div class="col-lg-12">
									<label for="TestForm_textField" class="control-label">Tùy chỉnh thời gian trong ngày để up tin (di chuyển các điểm xanh để chỉnh giờ)</label>
								</div>
								<div class="form-group col-lg-12">
									<div class="form-group float-left">
										<div class="time-line-region" style="position: relative;top: 20px;padding-bottom: 10px">
											<div id="up_calendar" style="position: relative;top: -3px;">
												<div id="tooltip" style="font-size: 11px;">
													<div id="result"></div>
													<div class="clear"></div>
												</div>
												<div class="clear"></div>
											</div>
											<div id="input_check_time"></div>
											<div class="time-line" style="position: relative;left: 7px"></div>
											<div style="position: relative; top: -9px;" class="time-line-text">
												<span class="rvTimeStep" style="margin-left:-8px">00:00</span>
												<span class="rvTimeStep" title="02:00" style="margin-left: 39px">02:00</span>
												<span class="rvTimeStep" title="04:00" style="margin-left: 42px">04:00</span>
												<span class="rvTimeStep" style="margin-left: 41px">06:00</span>
												<span class="rvTimeStep" style="margin-left:38px">08:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">10:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">12:00</span>
												<span class="rvTimeStep" style="margin-left:40px">14:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">16:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">18:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">20:00</span>
												<span class="rvTimeStep" style="margin-left: 40px">22:00</span>
												<span class="rvTimeStep" style="margin-left:30px">23:59</span>
											</div>
										</div>
									</div>
								</div>

								<!--Block 4-->
								<div class="clear"></div>
								<div class="float-left marginLeft20 marginTop20">
									<span id="button_submit"></span>
									<span id="sys_input_hidden"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>



