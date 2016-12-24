<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Quản lý banner quảng cáo</li>
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
                            <label for="banner_name">Tên banner</label>
                            <input type="text" class="form-control input-sm" id="banner_name" name="banner_name" placeholder="Tiêu đề banner" @if(isset($search['banner_name']) && $search['banner_name'] != '')value="{{$search['banner_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_province_id">Tỉnh thành</label>
                            <select name="banner_province_id" id="banner_province_id" class="form-control input-sm">
                                {{$optionProvince}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_type">Loại</label>
                            <select name="banner_type" id="banner_type" class="form-control input-sm">
                                {{$optionType}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="banner_page">Thuộc page</label>
                            <select name="banner_page" id="banner_page" class="form-control input-sm">
                                {{$optionPage}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Trạng thái</label>
                            <select name="banner_status" id="banner_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Vị trí hiển thị</label>
                            <select name="banner_position" id="banner_position" class="form-control input-sm">
                                {{$optionPosition}}
                            </select>
                        </div>
                        <div class="form-group col-lg-9 text-right">
                            @if($is_root || $permission_full ==1 || $permission_create == 1)
                                <a class="btn btn-danger btn-sm" href="{{URL::route('admin.bannerEdit')}}">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                    Thêm mới
                                </a>
                            @endif
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                @if($data && sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="2%" class="text-center">TT</th>
                            <th width="10%" class="text-center">Ảnh</th>
                            <th width="20%">Tên banner</th>
                            <th width="15%">Thông tin banner</th>
                            <th width="13%">Loại banner</th>
                            <th width="10%" class="text-center">Thuộc page</th>
                            <th width="10%" class="text-center">Ngày chạy</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center text-middle">{{ $stt + $key+1 }}</td>
                                <td class="text-center text-middle">
                                    <img src="{{ ThumbImg::getImageThumbBanner($item->banner_id,$item->banner_parent_id, $item->banner_image, CGlobal::sizeImage_100, $item->banner_name, true)}}">
                                </td>
                                <td>
                                    [<b>{{ $item->banner_id }}</b>] {{ $item->banner_name }}
                                    <br/>C: {{date('d-m-Y h:i',$item->banner_create_time)}}
                                   @if($item->banner_update_time > 0)<br/>U: {{date('d-m-Y h:i',$item->banner_update_time)}}@endif
                                </td>
                                <td>
                                    @if($item->banner_parent_id > 0)Banner ID cha: {{$item->banner_parent_id}} <br/>@endif
                                    @if($item->banner_position > 0){{$arrPosition[$item->banner_position]}} <br/>@endif
                                    @if($item->banner_order > 0)Thứ tự: {{$item->banner_order}} <br/>@endif
                                </td>
                                <td>
                                    @if(isset($arrTypeBanner[$item->banner_type])){{$arrTypeBanner[$item->banner_type]}}@else ---- @endif
                                    <br/><b>Danh mục: </b>@if(isset($arrCategory[$item->banner_category_id])){{$arrCategory[$item->banner_category_id]}}@else ----- @endif
                                    <br/><b>Tỉnh: </b>@if(isset($arrProvince[$item->banner_province_id])){{$arrProvince[$item->banner_province_id]}}@else Toàn quốc @endif
                                    <br/>@if($item->banner_is_rel == 1)Follow @else Nofollow @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if(isset($arrPage[$item->banner_page])){{$arrPage[$item->banner_page]}}@else ---- @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->banner_is_run_time == CGlobal::BANNER_IS_RUN_TIME)
                                        S:{{date('d-m-Y h:i',$item->banner_start_time)}}
                                        <br/>E:{{date('d-m-Y h:i',$item->banner_end_time)}}
                                    @else
                                        Không giới hạn
                                    @endif
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->banner_status  == CGlobal::status_show)
                                        <a href="javascript:void(0);" title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif

                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        &nbsp;&nbsp;&nbsp; <a href="{{URL::route('admin.bannerEdit',array('id' => $item->banner_id))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item->banner_id}},3)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item->banner_id}}"></span>
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
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>