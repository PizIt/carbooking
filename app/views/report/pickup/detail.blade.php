@extends('default')
@section('brand')
รายงานการเบิกน้ำมัน
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
                                            </div>
                                            <div class="col-md-3">
                                                <label><strong>หมายเลขทะเบียนรถ</strong> {{$car->car_no.' '.$car->car_province}}</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label><strong>กอง</strong> {{$car->car_dept}}</label>
                                            </div>
                                            <div class="col-md-3">
                                                 <label><strong>พขร. ที่รับผิดชอบรถ</strong> {{$driver->mem_name.' '.$driver->mem_lname}}</label>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="content">
                                            <div class="row">
    <!--                                            <div class="col-md-12">
                                                    <div class="header">
                                                        <strong>รายงานแบบสรุปตามเดือน</strong>
                                                    </div>-->

                                                    <div class="content table-responsive table-full-width" style="overflow-x:auto;">
                                                        <table class="table table-bordered table-striped fix" >
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" width="1%"><label>#</label></th>
                                                                    <th rowspan="2"  width="9%" style="text-align:center"><label>วันที่เบิก</label></th>
                                                                    <th rowspan="2" width="5.5%" style="text-align:center"><label>ครั้งที่</label></th>
                                                                    <th rowspan="2" width="15%" style="text-align:center"><label>ผู้เบิก</label></th>                                                                  
                                                                    <th rowspan="2" style="text-align:center"><label>ใช้ในงาน</label></th>
                                                                    <th colspan="2" width="18%" style="text-align:center"><label>น้ำมัน</label></th>
                                                                    <th rowspan="2" width="7%" style="text-align:center"><label>เลขที่ใบสั่งจ่าย</label></th>
                                                                    <th colspan="2" style="text-align:center"><label>ระยะทางเบิก</label></th>
                                                                    <th rowspan="2" widht="3%" style="text-align:center"><label>จัดการ</label></th>
                                                                </tr>
                                                                <tr>
                                                                    <th width="" style="text-align:center"><label>ประเภท</label></th>
                                                                    <th width="" style="text-align:center"><label>จำนวน</label></th>
                                                                    <th width="" style="text-align:center"><label>ครั้งก่อน</label></th>
                                                                    <th width="" style="text-align:center"><label>ปัจจุบัน</label></th>
                                                                </tr>
                                                            </thead> 
                                                            <tbody>
                                                                 @if(count($pickup)>0)
                                                                <?php 
                                                                   $util = new Util;
                                                                   $currentPage = $pickup->getCurrentPage();
                                                                   $perPage = $pickup->getPerPage();
                                                                   $cnt = ($currentPage*$perPage)-$perPage;
                                                               ?>
                                                               @foreach($pickup as $p)
                                                                    <?php 
                                                                         $date = $util->ThaiDate($p->pk_date_save);
                                                                         $month = $util->colvertListMonth($p->pk_month)
                                                                    ?>
                                                                <tr>
                                                                    <td style="text-align:center">{{++$cnt}}</td>
                                                                    <td>{{$date}}</td>
                                                                    <td>{{$p->pk_no.' / '.$month}}</td>
                                                                    <td>{{$p->mem_name.' '.$p->mem_lname}}</td>
                                                                    <td style="text-align:right"><div id="mylayout">{{$p->pk_for}}</div></td>
                                                                     <td>{{$p->pk_type_fuel}}</td>
                                                                    <td style="text-align:right">{{$p->pk_qty}}</td>
                                                                    <td style="text-align:right">{{$p->pk_order_no}}</td>
                                                                    <td style="text-align:right">{{$p->pk_early_km}}</td>
                                                                    <td style="text-align:right">{{$p->pk_now_km}}</td>
                                                                    <td style="text-align:left">
                                                                            <a href="{{url("manage/pickup/update/$p->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <center>{{$pickup->links()}} </center>
                                                </div>
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
@section('custom-style')
<style>
    div#mylayout{ 
        display:block; 
        width:100px; 
        word-wrap:break-word; 
} 
</style>
@stop
