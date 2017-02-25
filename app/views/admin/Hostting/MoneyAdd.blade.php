<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.hostting')}}"> Quản lý tiền quỹ</a></li>
            <li class="active">@if($id > 0)Cập nhật tiền quỹ @else Tạo mới tiền quỹ @endif</li>
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
                        <div class="col-lg-11" style="border-bottom: 2px solid #ccc"><h3 class="col-lg-12 text-center">Thông tin quỹ</h3></div>
                    </div>
                    <div class="col-sm-10 marginTop30">
                        <div class="form-group">
                            <label for="name" class="control-label">Lý do nhập-xuất<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Lý do nhập-xuất" id="money_name" name="money_name"  class="form-control input-sm" value="@if(isset($data['money_name'])){{$data['money_name']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Số tiền</label>
                            <input type="text" placeholder="Số tiền" id="money_price" name="money_price" class="formatMoney text-left form-control" data-v-max="999999999999999" data-v-min="0" data-a-sep="." data-a-dec="," data-a-sign=" đ" data-p-sign="s" value="@if(isset($data['money_price'])){{$data['money_price']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Kiểu nhập - xuất</label>
                            <select name="money_type" id="money_type" class="form-control input-sm">
                                {{$optionType}}
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <label for="name" class="control-label">Ghi chú </label><div class="clearfix"></div>
                        <textarea id="web_note" name="money_infor" rows="5" cols="70">@if(isset($data['money_infor'])){{$data['money_infor']}}@endif</textarea>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left marginTop20">
                        <a class="btn btn-warning" href="{{URL::route('admin.hostting')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
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

