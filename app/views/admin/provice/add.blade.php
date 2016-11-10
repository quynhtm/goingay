<div class="inner-box">
	<div class="page-title-box">
		<div class="wrapper">
			<h5 class="padding10">Tỉnh/Thành: @if($id==0)Thêm mới @else Sửa @endif</h5>
		</div>
	</div>
	<div class="page-content-box">
		@if($error != '')
		<div class="alert-admin alert alert-danger">{{ $error }}</div>
		@endif
		 <form class="form-horizontal paddingTop30" name="txtForm" action="" method="post" enctype="multipart/form-data">
             <div class="control-group">
                <label class="control-label">Tiêu đề<span>*</span></label>
                <div class="controls">
                    <input type="text" class="form-control input-sm" name="provice_title" value="@if(isset($data['provice_title'])){{$data['provice_title']}}@endif">
                </div>
             </div>
             <div class="control-group">
                <label class="control-label">Thứ tự</label>
                <div class="controls">
                    <input type="text" class="form-control input-sm" name="provice_order_no" value="@if(isset($data['provice_order_no'])){{$data['provice_order_no']}}@endif">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Trạng thái</label>
                <div class="controls">
                    <select class="form-control input-sm" name="provice_status">
                        {{$optionStatus}}
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
				<button type="submit" name="txtSubmit" id="buttonSubmit" class="btn btn-primary">Lưu lại</button>
                <button type="reset" class="btn">Bỏ qua</button>
            </div>
		 </form>
	</div>
</div>

