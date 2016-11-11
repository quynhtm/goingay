<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.province')}}"> Danh sách tỉnh thành</a></li>
            <li class="active">@if($id > 0)Cập nhật tỉnh thành @else Tạo mới tỉnh thành @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Tên tỉnh thành<span class="red"> (*) </span></label>
                        <input type="text" placeholder="Tên tỉnh thành" id="province_name" name="province_name"  class="form-control input-sm" value="@if(isset($data['province_name'])){{$data['province_name']}}@endif">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Vị trí hiển thị</label>
                        <input type="text" placeholder="Vị trí hiển thị" id="province_position" name="province_position"  class="form-control input-sm" value="@if(isset($data['province_position'])){{$data['province_position']}}@endif">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Trạng thái</label>
                        <select name="province_status" id="province_status" class="form-control input-sm">
                            {{$optionStatus}}
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-2 text-left"></div>
                <div class="form-group col-sm-10 text-left">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
                        <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

