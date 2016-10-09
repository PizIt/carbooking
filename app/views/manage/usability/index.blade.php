@extends('default')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <form method="GET" class="form-inline">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>เรียงตามรถ</label>
                                                <select class="form-control border-input" name="id">
                                                    <option value="">ทั้งหมด</option>
                                                    @foreach($car as $c)
                                                    <option value="{{$c->id}}" {{Input::get('id')==$c->id ? 'selected' : ''}}>{{$c->car_no.' '.$c->car_province}}</option>
                                                    @endforeach
                                                 </select>
                                                 </div>
                                                 <div class="form-group">
                                                    <input type="submit" class="btn btn-danger btn-block" value="แสดงข้อมูล">
                                                 </div>
                                        </div>
                                        @if(Session::get('level')==1)
                                        <div class="col-md-5">
                                              <div class="pull-right">
                                                  <a href="{{url('manage/usability/create')}}" class="btn btn-info">เพิ่มข้อมูลการใช้งานรถ</a>
                                              </div>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="header">
                                                <!--<strong>รายงานแบบสรุปตามเดือน</strong>-->
                                            </div>
                                            <div class="content table-responsive table-full-width" style="overflow-x:auto;">
                                                <table class="table table-bordered table-striped fix" >
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="1%"><label>#</label></th>
                                                            <th rowspan="2" width="10%"  style="text-align:center"><label>รถ</label></th>
                                                            <th colspan="2" width="6%" style="text-align:center"><label>ออกเดินทาง</label></th>
                                                            <th rowspan="2" width="15%" style="text-align:center"><label>ผู้ใช้รถ</label></th>
                                                            <th rowspan="2" width="15%" style="text-align:center"><label>สถานที่ไป</label></th>
                                                            <th rowspan="2" style="text-align:center"><label>ระยะทางก่อนใช้</label></th>
                                                            <th colspan="2" width="6%" style="text-align:center"><label>กลับถึงสำนักงาน</label></th>
                                                            <th rowspan="2" style="text-align:center"><label>ระยะทางหลังใช้</label></th>
                                                            <th rowspan="2" style="text-align:center"><label>รวมระยะ</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>พนักงานขับรถ</label></th>
                                                            <th rowspan="2" style="text-align:center"><label><i class="glyphicon glyphicon-asterisk"></i></label></th>
                                                            <th rowspan="2" style="text-align:center"><label>จัดการ</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="8%" style="text-align:center"><label>วันที่</label></th>
                                                            <th width="5%" style="text-align:center"><label>เวลา</label></th>
                                                            <th width="8%" style="text-align:center"><label>วันที่</label></th>
                                                            <th width="5%" style="text-align:center"><label>เวลา</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($useCar)>0)
                                                            <?php 
                                                                $date = new Util;
                                                                $currentPage=$useCar->getCurrentPage();
                                                                $perPage = $useCar->getPerPage();
                                                                $cnt = ($currentPage*$perPage)-$perPage;
                                                            ?>
                                                            @foreach($useCar as $u)
                                                                <?php
                                                                    $dstStart = $u->us_dst_start;
                                                                    $dstEnd = $u->us_dst_end;
                                                                ?>
                                                                <tr>
                                                                        <td>{{++$cnt}}</td>
                                                                        <td>{{$u->car_no.' '.$u->car_province}}</td>
                                                                        <td>{{$date->ThaiDate(substr($u->us_date_start,0,10));}}</td>
                                                                        <td>{{$date->DateTimeConvertToTimeView($u->us_date_start);}}</td>
                                                                        <td>{{$u->us_name_user}}</td>
                                                                        <td><div id="mylayout">{{$u->us_location}}</div></td>
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
                                                                        <td style="text-align:left">
                                                                            <a href="{{url("manage/usability/update/$u->usid")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                            <?php 
                                                                            if(($u->mid==Auth::id())&&($u->updated==TRUE) || (Session::get('level')>=3)) { ?>
                                                                                <a href="#" onclick="del({{$u->usid}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                                            <?php } ?>
                                                                        </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <center>
                                                    {{$useCar->appends(array('id'=>Input::get('id')))->links();}}
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
    $(function () {
         $('[data-toggle="note"]').tooltip()
    });
    function del(id)
    {
    swal({title:'ต้องการลบข้อมูลหรือไม่' ,type: 'question',showCancelButton: true})
            .then(function(){
                 location.replace('{{URL::to("manage/pickup/delete")}}/'+id);
            });
    }
</script>
@stop

@section('custom-style')
<style>
    div#mylayout{ 
        display:block; 
        width:100px; 
        word-wrap:break-word; 
} 
</style>
@stop
