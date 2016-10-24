@extends('default')
@section('brand')
จัดการข้อมูลรถ
@stop
@section('content')
<?php $disable = Session::get('level') <= 2 ? 'disabled style=background-color:#eee' : '' ?>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <a href="{{url('manage/car')}}" class="btn btn-default">
                                    <i class="glyphicon glyphicon-arrow-left"></i> กลับ
                                </a>
                            </div>
                            <div class="content">
                                <form name="form" data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>เลขทะเบียนรถ</label>
                                            <input type="text" name="car_no" class="form-control border-input" placeholder="XX 0000" value="{{!empty($car->car_no) ? $car->car_no :''}}" required {{$disable}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>จังหวัด</label>
                                            <input type="text" name="car_province" class="form-control border-input"  value="{{!empty($car->car_province) ? $car->car_province :''}}" required {{$disable}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>กอง</label>
                                             <select class="form-control border-input" name="car_dept" {{$disable}}>
                                                <option value="ช่าง" {{((!empty($car->car_dept))&&($car->car_dept=='ช่าง'))? 'selected': ''}}>ช่าง</option>
                                                <option value="คลัง" {{((!empty($car->car_dept))&&($car->car_dept=='คลัง'))? 'selected': ''}}>คลัง</option>
                                                <option value="การศึกษา" {{((!empty($car->car_dept))&&($car->car_dept=='การศึกษา'))? 'selected': ''}}>การศึกษา</option>
                                                <option value="สาธารณสุขและสิ่งแวดล้อม" {{((!empty($car->car_dept))&&($car->car_dept=='สาธารณสุขและสิ่งแวดล้อม'))? 'selected': ''}}>สาธารณสุขและสิ่งแวดล้อม</option>
                                                <option value="วิชาการและแผนงาน" {{((!empty($car->car_dept))&&($car->car_dept=='วิชาการและแผนงาน'))? 'selected': ''}}>วิชาการและแผนงาน</option>
                                                <option value="สวัสดีการสังคม" {{((!empty($car->car_dept))&&($car->car_dept=='สวัสดีการสังคม'))? 'selected': ''}}}}>สวัสดีการสังคม</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>ประเภทรถ</label>
                                           <select class="form-control border-input" name="car_type" {{$disable}}>
                                               <option value="รถตู้" {{(!empty($car->car_dept)&&($car->car_dept=="รถตู้")) ? 'selected' :''}}>รถตู้</option>
                                               <option value="รถกระบะ" {{(!empty($car->car_dept)&&($car->car_dept=="รถกระบะ")) ? 'selected' :''}}>รถกระบะ</option>
                                           </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>สถานะ</label>
                                            <select  class="form-control border-input" name="car_status" required {{$disable}}>
                                                <option value="Y" {{(!empty($car->car_status)&&($car->car_status=='Y')) ? 'selected':''}}>พร้อมใช้งาน</option>
                                                <option value="N" {{(!empty($car->car_status)&&($car->car_status=='N')) ? 'selected':''}}>ไม่พร้อมใช้งาน</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>วันที่หมดอายุพรบ.</label>
                                            <?php 
                                            if(!empty($car->car_act_exp)){
                                             $util  = new Util;
                                             $dateExp = $util->DateConvertToView($car->car_act_exp);
                                            }
                                            ?>
                                            <input type="text" name="car_act_exp" id="car_act_exp" placeholder="dd-MM-YYYY" class="form-control border-input" value="{{!empty($dateExp)?$dateExp:''}}" required {{$disable}}>
                                        </div>
                                    </div>
                                    
                                    @if(!empty($car->car_pic))
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img src="{{URL::to('img/cars/'.$car->car_pic.'')}}" class="img-rounded" width="250px" height="250px">
                                            </div>
                                    <!--    <div class="col-md-3">
                                                <img src="signature.png" width="150px" height="150px">
                                            </div>
                                    -->
                                        </div>
                                    @endif
                                    
                                    <div class="row">
                                        <?php  if(empty($disable)) { ?>
                                        <div class="col-md-3">
                                            <label>รูปรถ</label>
                                            <input type="file" name="car_pic"  class="form-control border-input">
                                        </div>
                                        <?php } ?>
                                        <div class="col-md-3">
                                            <label>พนักงานขับรถที่รับผิดชอบ</label>
                                            <select class="form-control border-input" name="car_driver_id" {{$disable}}>
                                                @if(count($driver)>0)
                                                @foreach($driver as $d)
                                                <option value="{{$d->id}}" {{(!empty($car->car_driver_id)&&($car->car_driver_id==$d->id)) ? 'selected' :''}} >{{$d->mem_name." ".$d->mem_lname}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>ระยะทางแจ้งเตือน(กิโลเมตร)</label>
                                            <input type="text" name="car_dst_alert" class="form-control border-input" value="{{!empty($car->car_dst_alert) ? $car->car_dst_alert :''}}" required {{$disable}}>
                                        </div>
                                    </div>              

                                    <hr>
                                    <?php  if(empty($disable)) { ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                            @if(!empty($car->id))
                                            <input type="hidden" name="id" value="{{$car->id}}">
                                            @endif
                                            <input type="submit" class="btn btn-danger btn-block" value="บันทึก">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="reset" class="btn btn-default btn-block" value="ล้าง">
                                        </div>
                                    </div>
                                    <?php } ?>
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $('#car_act_exp').datetimepicker({
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