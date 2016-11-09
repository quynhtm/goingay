<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách khách đăng tin</li>
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
                            <label for="customer_name">Tên Khách hàng</label>
                            <input type="text" class="form-control input-sm" id="customer_name" name="customer_name" placeholder="Tên khách hàng" @if(isset($search['customer_name']) && $search['customer_name'] != '')value="{{$search['customer_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="customer_email">Email</label>
                            <input type="text" class="form-control input-sm" id="customer_email" name="customer_email" placeholder="Email" @if(isset($search['customer_email']) && $search['customer_email'] != '')value="{{$search['customer_email']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="shop_status">Trạng thái</label>
                            <select name="customer_status" id="customer_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="shop_status">Loại shop</label>
                            <select name="is_customer" id="is_customer" class="form-control input-sm">
                                {{$optionIsCustomer}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($is_root || $permission_full ==1 || $permission_create == 1)
                        <span class="">
                            <a class="btn btn-danger" href="{{URL::route('admin.customerEdit')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        @endif
                        <span class="">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> Khách hàng @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT <input type="checkbox" class="check" id="checkAll"></th>
                            <th width="30%">Thông tin KH</th>
                            <th width="23%">Kiểu khách hàng</th>
                            <th width="10%" class="text-center text-middle">Online</th>
                            <th width="10%" class="text-center text-middle">Ngày tạo</th>
                            <th width="10%" class="text-center text-middle">Ngày active</th>
                            <th width="12%" class="text-center text-middle">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item->is_customer == CGlobal::CUSTOMER_VIP)style="background-color: #d6f6f6"@endif>
                                <td class="text-center">
                                    {{ $stt + $key+1 }}<br/>
                                    <input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item->customer_id}}">
                                </td>
                                <td>
                                    [<b>{{ $item->customer_id }}</b>] {{ $item->customer_name }}
                                    @if($item->customer_phone != '')
                                        <br/>{{ $item->customer_phone }}
                                    @endif
                                    @if($item->customer_email != '')
                                        <br/>{{ $item->customer_email }}
                                    @endif
                                </td>
                                <td class="text-middle">
                                    @if(isset($arrIsCustomer[$item->is_customer])){{ $arrIsCustomer[$item->is_customer] }}@else --- @endif
                                    <br/>∑ đã đăng:{{ $item->customer_up_item }}
                                    <br/>Địa chỉ: {{ $item->customer_address }}
                                </td>
                                <td class="text-center text-middle">
                                    @if($item->is_login == CGlobal::CUSTOMER_ONLINE)
                                        <i class="fa fa-smile-o fa-2x green"></i>
                                        <br/>{{date('H:i:s d-m-Y',$item->customer_time_login)}}
                                    @else
                                        <i class="fa fa-meh-o fa-2x red"></i>
                                        <br/>{{date('d-m-Y H:i:s ',$item->customer_time_logout)}}
                                    @endif
                                </td>
                                <td class="text-center text-middle">{{date('d-m-Y H:i:s ',$item->customer_time_created)}}</td>
                                <td class="text-center text-middle">{{date('d-m-Y H:i:s ',$item->customer_time_active)}}</td>
                                <td class="text-center text-middle">
                                    @if($item->customer_status == 1)
                                        <a href="javascript:void(0);"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @endif
                                    @if($item->customer_status == 0)
                                        <a href="javascript:void(0);"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                    @if($item->customer_status == -2)
                                        <a href="javascript:void(0);" style="color: red" title="Khóa"><i class="fa fa-close fa-2x"></i></a>
                                    @endif

                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.customerEdit',array('id' => $item->customer_id))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 2)
                                       <a href="javascript:void(0);" onclick="ADMIN.deleteItem({{$item->customer_id}},2)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <br/>
                                    @if($is_root)
                                        <a href=" {{URL::route('admin.loginToCustomer',array('id' => $item->customer_id))}}" style="color: red" title="Đăng nhập vào user" target="_blank"><i class="fa fa-sign-in fa-2x"></i></a>
                                    @endif
                                    <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading_{{$item->customer_id}}">
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
