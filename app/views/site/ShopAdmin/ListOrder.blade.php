<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('shop.adminShop')}}">Quản trị shop</a>
            </li>
            <li class="active">Đơn hàng</li>
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
                            <label for="order_product_name">Tên sản phẩm</label>
                            <input type="text" class="form-control input-sm" id="order_product_name" name="order_product_name" placeholder="Tên sản phẩm" @if(isset($search['order_product_name']))value="{{$search['order_product_name']}}"@endif>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="order_customer_name">Tên khách hàng</label>
                            <input type="text" class="form-control input-sm" id="order_customer_name" name="order_customer_name" placeholder="Tên khách hàng" @if(isset($search['order_customer_name']))value="{{$search['order_customer_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_customer_phone">SĐT khách hàng</label>
                            <input type="text" class="form-control input-sm" id="order_customer_phone" name="order_customer_phone" placeholder="SĐT khách hàng" @if(isset($search['order_customer_phone']))value="{{$search['order_customer_phone']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="order_customer_email">Email khách hàng</label>
                            <input type="text" class="form-control input-sm" id="order_customer_email" name="order_customer_email" placeholder="Email khách hàng" @if(isset($search['order_customer_email']))value="{{$search['order_customer_email']}}"@endif>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="name" class="control-label">Đặt hàng từ ngày </label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="time_start_time" name="time_start_time"  data-date-format="dd-mm-yyyy" value="@if(isset($data['time_start_time'])){{date('d-m-Y',$data['time_start_time'])}}@endif">
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="name" class="control-label">đến ngày</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="time_end_time" name="time_end_time"  data-date-format="dd-mm-yyyy" value="@if(isset($data['time_end_time'])){{date('d-m-Y',$data['time_end_time'])}}@endif">
                            </div>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="order_status">Trạng thái</label>
                            <select name="order_status" id="order_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> đơn hàng @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="25%">Thông tin sản phẩm</th>
                            <th width="25%" class="text-left">Thông tin khách hàng</th>
                            <th width="20%" class="text-left">Ghi chú của khách</th>
                            <th width="10%" class="text-center">Ngày đặt</th>
                            <th width="15%" class="text-center">Tình trạng ĐH</th>
                            <th width="8%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center text-middle">{{ $stt + $key+1 }}</td>
                                <td>
                                    [<b>{{ $item->order_product_id }}</b>]
                                    <a href="{{FunctionLib::buildLinkDetailProduct($item->order_product_id, $item->order_product_name, 'danh mục sản phẩm')}}" target="_blank" title="Chi tiết sản phẩm">
                                        {{ $item->order_product_name }}
                                    </a>
                                    <br/>Giá bán: <b class="red">{{ FunctionLib::numberFormat($item->order_product_price_sell) }} đ</b>
                                    <br/>SL: <b>{{ $item->order_quality_buy }}</b> sản phẩm
                                </td>
                                <td>
                                    @if($item->order_customer_name != '')Tên KH: <b>{{ $item->order_customer_name }}</b><br/>@endif
                                    @if($item->order_customer_phone != '')Phone: {{ $item->order_customer_phone }}<br/>@endif
                                    @if($item->order_customer_email != '')Email: {{ $item->order_customer_email }}<br/>@endif
                                    @if($item->order_customer_address != '')Địa chỉ: {{ $item->order_customer_address }}<br/>@endif
                                </td>
                                <td>
                                    @if($item->order_customer_note != ''){{ $item->order_customer_note }}@endif
                                </td>
                                <td class="text-center text-middle">{{ date ('d-m-Y H:i:s',$item->order_time) }}</td>
                                <td class="text-center text-middle">
                                    <select name="order_status_item" id="order_status_id_{{$item->order_id}}" class="form-control input-sm" onchange="CART.changeStatusOrder({{$item->order_id}},{{$user_shop->is_shop}})" title="Thay đổi trạng thái đơn hàng">
                                        @foreach($arrStatus as $kstatus => $nameStatus)
                                            <option value="{{$kstatus}}" @if($item->order_status == $kstatus) selected @endif>{{$nameStatus}}</option>
                                        @endforeach
                                    </select>
                                    @if(isset($arrStatus[$item->order_status]))<br/>{{$arrStatus[$item->order_status]}}@else --- @endif
                                </td>
                                <td class="text-center text-middle">
                                    <!--- export du lieu-->
                                    <br/><a href="{{URL::route('shop.exportOrder',array('order_id' => $item->order_id,'type' => 2))}}" target="_blank" title="Export kiểu PDF" ><i class="fa fa-file-pdf-o fa-2x"></i></a>
                                    <span class="img_loading" id="img_loading_{{$item->order_id}}"></span>
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
        var checkin = $('#time_start_time').datepicker({ });
        var checkout = $('#time_end_time').datepicker({ });
    });
</script>