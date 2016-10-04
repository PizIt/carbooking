@extends('default')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                          <div class="pull-right">
                                              <a href="{{url('manage/usability/create')}}" class="btn btn-info">เพิ่มข้อมูลการใช้งานรถ</a>
                                          </div>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>#</th>
                                            <th>วันเวลาที่เดินทาง</th>
                                            <th>ผู้ใช้รถ</th>
                                            <th>สถานที่ไป</th>
                                            <th>เลขกิโลก่อน</th>
                                            <th>วันเวลากลับ</th>
                                            <th>เลขกิโลหลัง</th>
                                            <th>รวมระยะ</th>
                                            <th>พนักงานขับรถ</th>
                                            <th>หมายเหตุ</th>
                                            <th>แก้ไข</th>
                                            <th>ลบ</th>
                                            </thead>
                                            <tbody>
                                                @if(count($useCar)>0)
                                                @foreach($useCar as $u)
                                                <?php
                                                $util = new Util;
                                                $dateStart = $util->ThaiDateTime($u->us_date_start);
                                                $dateEnd = $util->ThaiDateTime($u->us_date_end);
                                                $resultDst = $u->us_dst_end-$u->us_dst_start;
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td>{{$dateStart}}</td>
                                                    <td>{{$u->us_name_user}}</td>
                                                    <td>{{$u->us_location}}</td>
                                                    <td>{{$u->us_dst_start}}</td>
                                                    <td>{{$dateEnd}}</td>
                                                    <td>{{$u->us_dst_end}}</td>
                                                    <td>{{$resultDst}}</td>
                                                    <td>{{$u->mem_name.' '.$u->mem_lname}}</td>
                                                    <td><div id="mylayout">{{$u->us_note}}</div></td>
                                                    <td><a href="{{url("manage/usability/update/$u->id")}}">แก้ไข</a></td>
                                                    <td><a href="{{url("manage/usability/delete/$u->id")}}">ลบ</a></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{$useCar->links()}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<style>
    div#mylayout{ 
        display:block; 
        width:100px; 
        word-wrap:break-word; 
} 
</style>
@stop
