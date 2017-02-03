<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.hostting')}}"> Quản lý Website Hostting</a></li>
            <li class="active">@if($id > 0)Cập nhật tỉnh thành @else Tạo mới Website Hostting @endif</li>
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
                <div style="float: left; width: 50%; border-right: 1px solid #ccc">
                    <div class="form-group">
                        <div class="col-lg-11" style="border-bottom: 2px solid #ccc"><h3 class="col-lg-12 text-center">Thông tin Website</h3></div>
                    </div>
                    <div class="col-sm-10 marginTop30">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên Website<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên Website" id="web_name" name="web_name"  class="form-control input-sm" value="@if(isset($data['web_name'])){{$data['web_name']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Domain</label>
                            <input type="text" placeholder="Domain" id="web_domain" name="web_domain"  class="form-control input-sm" value="@if(isset($data['web_domain'])){{$data['web_domain']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Giá web</label>
                            <input type="text" placeholder="Giá web" id="web_price" name="web_price" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['web_price'])){{$data['web_price']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Hostting</label>
                            <select name="web_is_hostting" id="web_is_hostting" class="form-control input-sm">
                                {{$optionIsHostting}}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="web_status" id="web_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Ngày bắt đầu</label>
                            <input type="text" class="form-control" id="web_time_start" name="web_time_start"  data-date-format="dd-mm-yyyy" value="@if(isset($data['web_time_start']) && $data['web_time_start'] > 0){{date('d-m-Y',$data['web_time_start'])}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Ngày kết thúc</label>
                            <input type="text" class="form-control" id="web_time_end" name="web_time_end"  data-date-format="dd-mm-yyyy" value="@if(isset($data['web_time_end']) && $data['web_time_end'] > 0){{date('d-m-Y',$data['web_time_end'])}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <label for="name" class="control-label">Ghi chú thêm</label><div class="clearfix"></div>
                        <textarea id="web_note" name="web_note" rows="5" cols="70">@if(isset($data['web_note'])){{$data['web_note']}}@endif</textarea>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left marginTop20">
                        <a class="btn btn-warning" href="{{URL::route('admin.hostting')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>

                <div style="float: left; width: 50%;">
                    <div class="col-lg-11" id="show_infor_contract_one" @if(isset($data['contract_infor']) && $data['contract_infor'] == 1) style="display: none" @endif>
                        <div class="form-group">
                            <div class="col-lg-11" style="border-bottom: 2px solid #ccc"><h3 class="col-lg-12 text-center">Thông tin khách hàng</h3></div>
                        </div>

                        <div class="col-sm-10 marginTop30">
                            <div class="form-group">
                                <label for="name" class="control-label">Tên đại diện</label>
                                <input type="text" id="infor_name" name="infor_name" class="form-control" @if(isset($data['web_infor']['infor_name']))value="{{$data['web_infor']['infor_name']}}"@endif>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Chức vụ</label>
                                <input type="text" id="infor_stand" name="infor_stand" class="form-control" @if(isset($data['web_infor']['infor_stand']))value="{{$data['web_infor']['infor_stand']}}"@endif>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Email</label>
                                <input type="text" id="infor_email" name="infor_email" class="form-control" @if(isset($data['web_infor']['infor_email']))value="{{$data['web_infor']['infor_email']}}"@endif>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Phone</label>
                                <input type="text" id="infor_phone" name="infor_phone" class="form-control" @if(isset($data['web_infor']['infor_phone']))value="{{$data['web_infor']['infor_phone']}}"@endif>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Địa chỉ</label>
                                <input type="text" id="infor_address" name="infor_address" class="form-control" @if(isset($data['web_infor']['infor_address']))value="{{$data['web_infor']['infor_address']}}"@endif>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Giá Domain gia hạn</label>
                                <input type="text" id="infor_price_domain" name="infor_price_domain" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['web_infor']['infor_price_domain'])){{$data['web_infor']['infor_price_domain']}}@endif">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-sm-10">
                            <div class="form-group">
                                <label for="name" class="control-label">Giá Hostting gia hạn</label>
                                <input type="text" id="infor_price_host" name="infor_price_host" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['web_infor']['infor_price_host'])){{$data['web_infor']['infor_price_host']}}@endif">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name" class="control-label">Hostting</label>
                                <select name="web_is_return" id="web_is_return" class="form-control input-sm">
                                    {{$optionIsReturn}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    jQuery('.formatMoney').autoNumeric('init');
    $(document).ready(function(){
        var start_time = $('#web_time_start').datepicker({ });
        var end_time = $('#web_time_end').datepicker({ });
    });
</script>

