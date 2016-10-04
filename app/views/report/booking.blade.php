@extends('default')
@section('brand')
รายงานการจองรถ
@stop
@section('content')
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form class="form-inline" method="GET">                    
                                    <div class="row">
                                        <div class="col-md-12">                                       
                                            <div class="form-group">
                                                <label>วันที่</label>
                                                <input type="text" id="dateStart" name="dateStart" placeholder="วันที่ต้องการค้นหา" value="{{Input::get('dateStart')}}" class="form-control border-input">
                                            </div>
                                            <div class="form-group">
                                                <label>ถึง</label>
                                                <input type="text" id="dateEnd" name="dateEnd" value="{{Input::get('dateEnd')}}"  placeholder="วันที่สิ้นสุด" class="form-control border-input">
                                            </div>
                                            <div class="form-group">
                                                <label>กอง</label>
                                                <select class="form-control border-input" name="dept">
                                                    <option value="">ทั้งหมด</option>
                                                    <option value="สำนักปลัด" {{Input::get('dept')=='สำนักปลัด'? 'selected': ''}}>สำนักปลัด</option>
                                                    <option value="ช่าง" {{Input::get('dept')=='ช่าง'? 'selected': ''}}>ช่าง</option>
                                                    <option value="คลัง" {{Input::get('dept')=='คลัง'? 'selected': ''}}>คลัง</option>
                                                    <option value="การศึกษา" {{Input::get('dept')=='การศึกษา'? 'selected': ''}}>การศึกษา</option>
                                                    <option value="สาธารณสุขและสิ่งแวดล้อม" {{Input::get('dept')=='สาธารณสุขและสิ่งแวดล้อม'? 'selected': ''}}>สาธารณสุขและสิ่งแวดล้อม</option>
                                                    <option value="วิชาการและแผนงาน" {{Input::get('dept')=='วิชาการและแผนงาน'? 'selected': ''}}>วิชาการและแผนงาน</option>
                                                    <option value="สวัสดีการสังคม" {{Input::get('dept')=='สวัสดีการสังคม'? 'selected': ''}}>สวัสดีการสังคม</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>ชื่อผู้จอง</label>
                                                <input type="text" placeholder="ชื่อ - สกุลผู้จอง" class="form-control border-input" name="member" value="{{Input::get('member')}}">
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-danger btn-block" value="ค้นหา">
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <hr>
                                    <div class="row">
                                      
                                        <div class="card">
                                            <div class="header">
                                                <strong>รายการจองรถ</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td><label>#</label></td>
                                                            <td><label>ผู้จอง</label></td>
                                                            <td><label>ใช้เพื่อ</label></td>
                                                            <td><label>สถานที่เดินทาง</label></td>
                                                            <td style="width:15% "><label>วันเวลา</label></td>
                                                            <td style="width:15%"><label>ถึงเวลา</label></td>
                                                            <td style="width:10%"><label>สถานะ</label></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($listBooking)>=0)
                                                        @foreach($listBooking as $l)
                                                          <?php 
                                                            $status = $l->book_confirm;
                                                            $color = "";
                                                           if($status=='1' || $status=='2')
                                                            {
                                                                $status = "รอการอนุมัติ";
                                                                $color = "text-warning";
                                                            }else  if($status=='3'){
                                                                $status = "อนุมัติแล้ว";
                                                                $color = "text-success"; 
                                                            }
                                                            else if($status=='0'){
                                                                $status = "ไม่อนุมัติ";
                                                                $color = "text-danger"; 
                                                            }
                                                            $util = new Util;
                                                            $dataStart = substr($util->ThaiDateTime($l->book_date_from),0,16);
                                                            $dataEnd = substr($util->ThaiDateTime($l->book_date_to),0,16);
                                                            ?>
                                                            <tr>
                                                                <td>1</td>
                                                                <td><a href="{{URL::to('report/booking/detail')}}">{{$l->mem_name.' '.$l->mem_lname}}</a></td>
                                                                <td>{{$l->book_for}}</td>
                                                                <td>{{$l->book_location}}</td>
                                                                <td>{{$dataStart}}</td>
                                                                <td>{{$dataEnd}}</td>
                                                                <td class="{{$color}}">{{$status}}</td>
                                                            </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <center>
                                                  {{$listBooking->links()}}
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>                                 
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
        format:'d-m-Y',
        timepicker:false,
        yearOffset:543
         });
    $('#dateEnd').datetimepicker({
       value:'',
       format:'d-m-Y',
       timepicker:false,
       yearOffset:543
        });
</script>
@stop