@extends('default')
@section('brand')
บันทึกการเบิกน้ำมัน
@stop
@section('content')
   <?php 
        $disable="";
        if(Request::segment(3)!='create'){
        $disable = ((((Session::get('level') > 2) || (Auth::id()==$pickup->pk_id_driver))) && ($update==true)) ? '' : 'disabled style=background-color:#eee';
        }
    ?>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <strong>เลือกรถและพนักงานขับรถที่ต้องการบันทึกข้อมูล</strong>
                                 <div class="pull-right">
                                    <a href="{{url('manage/pickup/index')}}" class="btn btn-default">กลับ</a>
                            </div>
                            <div class="content">
                                <form method="POST" name="form" data-toggle="validator" role="form">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>วันที่</label>
                                                <?php 
                                                    if(!empty($pickup->pk_date_save))
                                                    {
                                                        $util = new Util;
                                                        $dateSave = $util->DateConvertToView($pickup->pk_date_save);
                                                    }
                                                ?>
                                                <input type="text" id="dateSave" class="form-control border-input" name="pk_date_save" 
                                                       value="{{!empty($pickup->pk_date_save) ? $dateSave: ''}}" {{$disable}}>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <label>เบิกครั้งที่</label>
                                                <input type="text" class="form-control border-input" name="pk_no" value="{{!empty($pickup->pk_no) ? $pickup->pk_no : ''}}" {{$disable}}>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>ประจำเดือน</label>
                                                <select class="form-control border-input" name="pk_month" {{$disable}}>
                                                       <?php $month = array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ",
                                                "กรกฎาคม ","สิงหาคม ","กันยายน ","ตุลาคม ","พฤศจิกายน ","ธันวาคม ");
                                                    ?>
                                                    <?php for($i=0 ; $i<sizeof($month);$i++){?>
                                                    <option value="<?php echo $month[$i]; ?>" {{(!empty(Input::get('month'))&&($i==Input::get('month'))) ? 'selected' : ''}}><?php echo $month[$i];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>                     
                                        </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>ชื่อผู้เบิก</label>
                                            <select class="form-control border-input" name="pk_id_driver" {{$disable}}>
                                                @foreach($memberPick as $m)
                                                <option value="{{$m->id}}" {{!empty($pickup->pk_id_driver) &&($pickup->pk_id_driver==$m->id) ? 'selected': ''}}>{{$m->mem_name.' '.$m->mem_lname }} (พนักงานขับรถ)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>รถที่ต้องการเบิกน้ำมัน</label>
                                            <select class="form-control border-input" name="pk_car_id" {{$disable}}>
                                                @foreach($cars as $c)
                                                    <option value="{{$c->id}}" {{!empty($pickup->pk_car_id) &&($pickup->pk_car_id==$c->id) ? 'selected': ''}}>{{$c->car_no.' '.$c->car_province.' ('.$c->car_type.')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label>ใช้ในงาน</label>
                                            <input type="text" class="form-control border-input" name="pk_for" value="{{!empty($pickup->pk_for) ? $pickup->pk_for : ''}}" required {{$disable}}>
                                        </div>
                                    </div>
                                        <hr>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>ประเภทน้ำมันที่ต้องการเบิก</label>
                                            <select class="form-control border-input" name="pk_type_fuel" {{$disable}}>
                                                <option value="น้ำมันเบนซิลธรรมดา" {{!empty($pickup->pk_type_fuel) &&($pickup->pk_type_fuel=='น้ำมันเบนซิลธรรมดา') ? 'selected': ''}}>น้ำมันเบนซิลธรรมดา</option>
                                                <option value="น้ำมันเบนซิลซุปเปอร์" {{!empty($pickup->pk_type_fuel) &&($pickup->pk_type_fuel=='น้ำมันเบนซิลซูเปอร์') ? 'selected': ''}}>น้ำมันเบนซิลซูเปอร์</option>
                                                <option value="น้ำมันดีเซล" {{!empty($pickup->pk_type_fuel) &&($pickup->pk_type_fuel=='น้ำมันดีเซล') ? 'selected': ''}}>น้ำมันดีเซล</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>จำนวน(ลิตร)</label>
                                            <input type="number" class="form-control border-input" name="pk_qty" value="{{!empty($pickup->pk_qty) ? $pickup->pk_qty : ''}}" required {{$disable}}>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label>รายละเอียดการเบิก</label>
                                            <textarea rows="5" class="form-control border-input" name="pk_details" {{$disable}}>{{!empty($pickup->pk_details) ? $pickup->pk_details : ''}}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label>เบิกครั้งก่อนเข็มไมลค์</label>
                                            <input type="text" class="form-control border-input" name="pk_early_km" value="{{!empty($pickup->pk_early_km) ? $pickup->pk_early_km : ''}}" required {{$disable}}>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เบิกครั้งนี้เข็มไมลค์</label>
                                            <input type="text" class="form-control border-input" name="pk_now_km" value="{{!empty($pickup->pk_now_km) ? $pickup->pk_now_km : ''}}" required {{$disable}}>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เลขที่ใบสั่งจ่าย</label>
                                            <input type="text" class="form-control border-input" name="pk_order_no" value="{{!empty($pickup->pk_order_no) ? $pickup->pk_order_no : ''}}" required {{$disable}}>
                                        </div>
                                    </div>
                                        @if(!empty($pickup->id))
                                            <input type="hidden" name="id" value="{{$pickup->id}}" {{$disable}}>
                                        @endif
                                        @if(empty($disable))
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <input type="submit" class="btn btn-danger btn-block" value="บันทึก">
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="reset" class="btn btn-default btn-block" value="ล้าง">
                                                </div>
                                            </div>
                                        @endif
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $('#dateSave').datetimepicker({
        value:'',
        format:'d-m-Y',
        timepicker:false,
        yearOffset:543
        });
    //Set DatetimePicker
    $.datetimepicker.setLocale('th');
    //Form Validator
    $('#form').validator();
</script>
@stop
@section('costom-style')
   <!--JS IN HEAD-->
   <!--datetimepicker-->
        <link rel="stylesheet" type="text/css" href="{{URL::to('assets/datetimepicker/jquery.datetimepicker.css')}}" >
        <script src="{{URL::to('assets/datetimepicker/jquery.js')}}"></script>
        <script src="{{URL::to('assets/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>
    <!--validations-->
        <script src="{{URL::to('assets/validator/js/validator.js')}}"></script>
@stop