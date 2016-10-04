@extends('default')
@section('content')
 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <strong>เลือกรถและพนักงานขับรถที่ต้องการบันทึกข้อมูล</strong>
                                <div class="pull-right">
                                    <a href="{{url('manage/usability/index')}}" class="btn btn-info">กลับ</a>
                            </div>
                            </div>
                            <div class="content">
                                <form method="POST" name="form"  data-toggle="validator" role="form">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>หมายเลขทะเบียนรถ</label>
                                                <select class="form-control border-input" name="us_car_id">
                                                   @foreach($cars as $c)
                                                   <option value="{{$c->id}}" {{!empty($useCar->us_car_id)&&($c->id==$useCar->us_car_id) ? 'selected' : ''}}>{{$c->car_no.' '.$c->car_province.' ('.$c->car_type.')'}}</option>
                                                   @endforeach
                                               </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>ชื่อพนักงานขับรถ</label>
                                                <select class="form-control border-input" name="us_id_driver">
                                                     @foreach($drivers as $d)
                                                     <option value="{{$d->id}}" {{!empty($useCar->us_id_driver)&&($d->id==$useCar->us_id_driver) ? 'selected' : ''}}>{{$d->mem_name.' '.$d->mem_lname}}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <hr>
                                    <?php 
                                    $util = new Util;
                                    $dateStart="";
                                    $dateEnd="";
                                    if(!empty($useCar))
                                    {
                                        $dateStart = $util->DateTimeConvertToView(substr($useCar->us_date_start,0,16));
                                        $dateEnd = $util->DateTimeConvertToView(substr($useCar->us_date_end,0,16));
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>วันเวลาที่เดินทาง</label>
                                            <input type="text" id="dateStart"  name="us_date_start" class="form-control border-input" value="{{!empty($useCar->us_date_start)? $dateStart : ''}}" required placeholder="dd-MM-YYYY HH:ii">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>ชื่อผู้ใช้รถ</label>
                                            <input type="text"  name="us_name_user" class="form-control border-input" value="{{!empty($useCar->us_name_user)? $useCar->us_name_user : ''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>สถานที่ไป</label>
                                            <input type="text"  name="us_location" class="form-control border-input" value="{{!empty($useCar->us_location)? $useCar->us_location : ''}}" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>วันเวลาที่กลับสำนักงาน</label>
                                            <input type="text" id="dateEnd"  name="us_date_end" class="form-control border-input" value="{{!empty($useCar->us_date_end)? $dateEnd : ''}}" required placeholder="dd-MM-YYYY HH:ii">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label>เลขกิโลก่อนเดินทาง</label>
                                            <input type="number" name="us_dst_start" class="form-control border-input" value="{{!empty($useCar->us_dst_start)? $useCar->us_dst_start : ''}}" required>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>เลขกิโลหลังเดินทาง</label>
                                            <input type="number"  name="us_dst_end" class="form-control border-input" value="{{!empty($useCar->us_dst_end)? $useCar->us_dst_end : ''}}" required> 
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>หมายเหตุ</label>
                                            <input type="text"  name="us_note" class="form-control border-input" value="{{!empty($useCar->us_note)? $useCar->us_note : ''}}">
                                        </div>
                                    </div>
                                        <input type="hidden" name="id" value="{{!empty($useCar->id) ? $useCar->id : ''}}">
                                        <div class="row">
                                            <div class="col-md-1">
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
    $('#dateStart').datetimepicker({
        value:'',
        format:'d-m-Y H:i',
        yearOffset:543
        });
    $('#dateEnd').datetimepicker({
        value:'',
        format:'d-m-Y H:i',
        yearOffset:543
        });
</script>
@stop
