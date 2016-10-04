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
                                              <a href="{{url('manage/pickup/create')}}" class="btn btn-info">เพิ่มข้อมูลการเบิกน้ำมัน</a>
                                          </div>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>#</th>
                                            <th>วันที่เบิก</th>
                                            <th>ชื่อผู้เบิก</th>
                                            <th>รถที่ใช้เบิก</th>
                                            <th>ประเภทน้ำมัน</th>
                                            <th>จำนวน</th>
                                            <th>แก้ไข</th>
                                            <th>ลบ</th>
                                            </thead>
                                            <tbody>
                                                @if(count($pickup)>0)
                                                @foreach($pickup as $p)
                                                <?php 
                                                $util = new Util;
                                                $date = $util->ThaiDate($p->pk_date_save);
                                                ?>
                                                <tr>
                                                    <td>{{''}}</td>
                                                    <td>{{$date}}</td>
                                                    <td>{{$p->mem_name.' '.$p->mem_lname}}</td>
                                                    <td>{{$p->car_no.' '.$p->car_province}}</td>
                                                    <td>{{$p->pk_type_fuel}}</td>
                                                    <td>{{$p->pk_qty}}</td>
                                                    <td><a href="{{url("manage/pickup/update/$p->id")}}">แก้ไข</a></td>
                                                    <td><a href="{{url("manage/pickup/delete/$p->id")}}">ลบ</a></td>
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
                    </div>
                </div>
            </div>
        </div>
@stop