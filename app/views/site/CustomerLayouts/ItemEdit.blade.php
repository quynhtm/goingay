<div class="col-left-92">
	<div class="head-info">
		<h2><a href=""><i class="fa fa-upload"></i> Đăng tin </a></h2>
	</div>
	<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	{{Form::open(array('role'=>'form','method' => 'POST','url' =>URL::route('customer.ItemsEdit',array('item_id'=>$item_id)),'files' => true))}}
	@if(isset($error) && !empty($error))
		<div class="alert alert-danger" role="alert">
			@foreach($error as $itmError)
				<p>{{ $itmError }}</p>
			@endforeach
		</div>
	@endif

	<div class="col-sm-12">
		<div class="form-group">
			<label for="name" class="control-label">Tên tin đăng <span class="red"> (*) </span></label>
			<input type="text" placeholder="Tên tin đăng" id="item_name" name="item_name"  class="form-control input-sm" value="@if(isset($data['item_name'])){{$data['item_name']}}@endif">
		</div>
	</div>

	<div class="clearfix"></div>
	<div style="float: left; width: 50%">
		<div class="col-sm-12">
			<div class="form-group">
				<label for="name" class="control-label">Danh mục<span class="red"> (*) </span></label>
				<div class="form-group">
					<select name="item_category_id" id="item_category_id" class="form-control input-sm">
						{{$optionCategory}}
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label for="name" class="control-label">Loại tin đăng</label>
				<div class="form-group">
					<select name="item_type_action" id="item_type_action" class="form-control input-sm">
						{{$optionTypeAction}}
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label for="name" class="control-label">Trạng thái Ẩn/Hiện</label>
				<div class="form-group">
					<select name="item_status" id="item_status" class="form-control input-sm">
						{{$optionStatusProduct}}
					</select>
				</div>
			</div>
		</div>
	</div>

	<div style="float: left; width: 50%">
		<div class="col-sm-12">
			<div class="form-group">
				<label for="name" class="control-label">Kiểu hiển thị giá<span class="red"> (*) </span></label>
				<div class="form-group">
					<select name="item_type_price" id="item_type_price" class="form-control input-sm">
						{{$optionTypePrice}}
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label for="name" class="control-label">Giá bán <span class="red"> (*) </span></label>
				<input type="text" placeholder="Giá bán" id="item_price_sell" name="item_price_sell" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['item_price_sell'])){{$data['item_price_sell']}}@endif">
			</div>
		</div>
	</div>
	<div>
		<div class="col-sm-12">
			<div class="form-group">
				<a href="javascript:;"class="btn btn-primary" onclick="SITE.uploadImagesItem(2);">Upload ảnh </a>
				<input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['item_image'])){{$data['item_image']}}@endif">
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-sm-12">
			<!--hien thi anh-->
			<ul id="sys_drag_sort" class="ul_drag_sort">
				@if(isset($arrViewImgOther))
					@foreach ($arrViewImgOther as $key => $imgNew)
						<li id="sys_div_img_other_{{$key}}" style="margin: 1px!important;">
							<div class='block_img_upload'>
								<div class="thumb">
									<img src="{{$imgNew['src_img_other']}}" height='100' width='100'>
								</div>
								<input type="hidden" id="img_other_{{$key}}" name="img_other[]" value="{{$imgNew['img_other']}}" class="sys_img_other">
								<div class='clear'></div>
								<input type="radio" id="checked_image_{{$key}}" name="checked_image" value="{{$key}}" @if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] ) checked="checked" @endif onclick="SITE.checkedImage('{{$imgNew['img_other']}}','{{$key}}');">
								<label for="checked_image_{{$key}}" style='font-weight:normal'>Ảnh đại diện</label>
								<div class="clearfix"></div>
								<a href="javascript:void(0);" onclick="SITE.removeImage({{$key}},{{$item_id}},'{{$imgNew['img_other']}}');">Xóa ảnh</a>
								<span style="display: none"><b>{{$key}}</b></span>
							</div>
						</li>
						@if(isset($imagePrimary) && $imagePrimary == $imgNew['img_other'] )
							<input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="{{$key}}">
						@endif
					@endforeach
				@else
					<input type="hidden" id="products_images_key_upload" name="products_images_key_upload" value="-1">
				@endif
			</ul>
	
			<input name="list1SortOrder" id ='list1SortOrder' type="hidden" />
			<script type="text/javascript">
				$("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
				function saveOrder() {
					var data = $("#sys_drag_sort li div span").map(function() { return $(this).children().html(); }).get();
					$("input[name=list1SortOrder]").val(data.join(","));
				};
			</script>
			<!--ket thuc hien thi anh-->
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-sm-12">
		<div class="form-group">
			<label for="name" class="control-label">Thông tin chi tiết <span class="red"> (*) </span>
				<div class="controls"><button type="button" onclick="SITE.insertImageContentItem()" class="btn btn-primary">Chèn ảnh vào nội dung</button></div>
				</label>
				<textarea class="form-control input-sm" rows="8" name="item_content" id="item_content">@if(isset($data['item_content'])){{$data['item_content']}}@endif</textarea>
			</div>
		</div>
		<div class="clearfix"></div>

		<div class="form-group col-sm-12 text-left">
			<button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Đăng tin</button>
		</div>
		<input type="hidden" id="id_hiden" name="id_hiden" value="{{$item_id}}"/>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	jQuery('.formatMoney').autoNumeric('init');
	CKEDITOR.replace('item_content', {height:600});
	function insertImgContent(src, item_name){
		CKEDITOR.instances.item_content.insertHtml('<img src="'+src+'" alt="'+item_name+'"/>');
	}
</script>

<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                        <div id="status"></div>

                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->

<!--Popup anh khac de chen vao noi dung bai viet-->
<div class="modal fade" id="sys_PopupImgOtherInsertContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Click ảnh để chèn vào nội dung</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image_insert_content" class="float_left"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- chen anh vào noi dung-->