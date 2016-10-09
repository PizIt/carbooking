@extends('default')
@section('brand')
รายงานการใช้งานรถ
@stop
@section('content') 
 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <form>
                                        <div class="row">
                                            <div class="col-md-3">
                                                 <label><strong>เดือน / ปี </strong>[{{$txtDate}}] </label>
                                                <!--<input type="text"  class="form-control border-input" disabled value="{{$driver->mem_name.' '.$driver->mem_lname}}">-->
                                            </div>
                                            <div class="col-md-3">
                                                <label><strong>หมายเลขทะเบียนรถ</strong> {{$car->car_no.' '.$car->car_province}}</label>
                                                 <!--<input type="text"  class="form-control border-input" disabled value="{{$car->car_no.' '.$car->car_province}}">-->
                                            </div>
                                            <div class="col-md-3">
                                                <label><strong>กอง</strong> {{$car->car_dept}}</label>
                                               <!--<input type="text"  class="form-control border-input" disabled value="{{$car->car_dept}}">-->
                                            </div>
                                            <div class="col-md-3">
                                                 <label><strong>พขร. ที่รับผิดชอบรถ</strong> {{$driver->mem_name.' '.$driver->mem_lname}}</label>
                                                <!--<input type="text"  class="form-control border-input" disabled value="{{$driver->mem_name.' '.$driver->mem_lname}}">-->
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12">
<!--                                                <div class="header">
                                                    <strong>รายงานแบบสรุปตามเดือน</strong>
                                                </div>-->
                                                <div class="content table-responsive table-full-width" style="overflow-x:auto;">
                                                    <table class="table table-bordered table-striped fix" >
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2" width="1%"><label>#</label></th>
                                                                <th colspan="2" width="6%" style="text-align:center"><label>ออกเดินทาง</label></th>
                                                                <th rowspan="2" width="15%" style="text-align:center"><label>ผู้ใช้รถ</label></th>
                                                                <th rowspan="2" width="15%" style="text-align:center"><label>สถานที่ไป</label></th>
                                                                <th rowspan="2" style="text-align:center"><label>ระยะทางก่อนใช้</label></th>
                                                                <th colspan="2" width="6%" style="text-align:center"><label>กลับถึงสำนักงาน</label></th>
                                                                <th rowspan="2" style="text-align:center"><label>ระยะทางหลังใช้</label></th>
                                                                <th rowspan="2" style="text-align:center"><label>รวมระยะ</label></th>
                                                                <th rowspan="2" style="text-align:center"><label>พนักงานขับรถ</label></th>
                                                                <th rowspan="2" style="text-align:center"><label><i class="glyphicon glyphicon-asterisk"></i></label></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="8%" style="text-align:center"><label>วันที่</label></th>
                                                                <th width="5%" style="text-align:center"><label>เวลา</label></th>
                                                                <th width="8%" style="text-align:center"><label>วันที่</label></th>
                                                                <th width="5%" style="text-align:center"><label>เวลา</label></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($usecar)>0)
                                                                <?php 
                                                                    $date = new Util;
                                                                    $currentPage=$usecar->getCurrentPage();
                                                                    $perPage = $usecar->getPerPage();
                                                                    $cnt = ($currentPage*$perPage)-$perPage;
                                                                    $cnt=1;
                                                                ?>
                                                                @foreach($usecar as $u)
                                                                    <?php 
                                                                        $dstStart = $u->us_dst_start;
                                                                        $dstEnd = $u->us_dst_end;
                                                                    ?>
                                                                    <tr>
                                                                        <td>{{++$cnt}}</td>
                                                                        <td>{{$date->ThaiDate(substr($u->us_date_start,0,10));}}</td>
                                                                        <td>{{$date->DateTimeConvertToTimeView($u->us_date_start);}}</td>
                                                                        <td>{{$u->us_name_user}}</td>
                                                                        <td>{{$u->us_location}}</td>
                                                                        <td style="text-align:right">{{$dstStart}}</td>
                                                                        <td>{{$date->ThaiDate(substr($u->us_date_end,0,10));}}</td>
                                                                        <td>{{$date->DateTimeConvertToTimeView($u->us_date_end);}}</td>
                                                                        <td style="text-align:right">{{$dstEnd}}</td>
                                                                        <td style="text-align:right">{{$dstEnd-$dstStart}}</td>
                                                                        <td>{{$u->mem_name.' '.$u->mem_lname}}</td>
                                                                        <?php if(!empty($u->us_note)){?>
                                                                            <td style="text-align:center"><i class="glyphicon glyphicon-asterisk info" data-toggle="note" data-placement="top" title="{{$u->us_note}}"></i></td>
                                                                        <?php } else{?>
                                                                            <td style="text-align:center"></td>
                                                                        <?php }?>
                                                                    </tr>
                                                                 @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <center>{{$usecar->links();}}</center>
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
    $(function () {
  $('[data-toggle="note"]').tooltip()
})
 </script>
@stop
