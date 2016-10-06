@extends('default')
@section('content')
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                               <a href="{{URL::to('manage/car')}}">กลับ</a>
                            </div>
                            <div class="content">
                                <form name="form" data-toggle="validator" role="form" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>เลขทะเบียนรถ</label>
                                            <input type="text" name="car_no" class="form-control border-input" placeholder="XX 0000" value="{{!empty($car->car_no) ? $car->car_no :''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>จังหวัด</label>
                                            <input type="text" name="car_province" class="form-control border-input"  value="{{!empty($car->car_province) ? $car->car_province :''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>กอง</label>
                                             <select class="form-control border-input" name="car_dept">
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
                                           <select class="form-control border-input" name="car_type">
                                               <option value="รถตู้" {{(!empty($car->car_dept)&&($car->car_dept=="รถตู้")) ? 'selected' :''}}>รถตู้</option>
                                               <option value="รถกระบะ" {{(!empty($car->car_dept)&&($car->car_dept=="รถกระบะ")) ? 'selected' :''}}>รถกระบะ</option>
                                           </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>สี</label>
                                            <input type="text" name="car_color" class="form-control border-input" value="{{!empty($car->car_color) ? $car->car_color :''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>วันที่หมดอายุพรบ.</label>
                                            <?php 
                                            if(!empty($car->car_act_exp)){
                                             $util  = new Util;
                                             $dateExp = $util->DateConvertToView($car->car_act_exp);
                                            }
                                            ?>
                                            <input type="text" name="car_act_exp" id="car_act_exp" placeholder="dd-MM-YYYY" class="form-control border-input" value="{{!empty($dateExp)?$dateExp:''}}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>รูปรถ</label>
                                            <input type="file" name="car_pic"  class="form-control border-input">
                                        </div>
                                        <div class="col-md-3">
                                            <label>พนักงานขับรถที่รับผิดชอบ</label>
                                            <select class="form-control border-input" name="car_driver_id">
                                                @if(count($driver)>0)
                                                @foreach($driver as $d)
                                                <option value="{{$d->id}}" {{(!empty($car->car_driver_id)&&($car->car_driver_id==$d->id)) ? 'selected' :''}} >{{$d->mem_name." ".$d->mem_lname}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>ระยะทางแจ้งเตือน(กิโลเมตร)</label>
                                            <input type="text" name="car_dst_alert" class="form-control border-input" value="{{!empty($car->car_dst_alert) ? $car->car_dst_alert :''}}" required>
                                        </div>
                                    </div>              

                                    <hr>

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
</script>
@stop