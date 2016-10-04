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
                                              <a href="{{url('manage/car/create')}}" class="btn btn-info">เพิ่มข้อมูลรถ</a>
                                          </div>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>#</th>
                                            <th>เลขทะเบียนรถ</th>
                                            <th>จังหวัด</th>
                                            <th>ประเภท</th>
                                             <th>กอง</th>
                                            <th>สี</th>
                                            <th>วันหมดอายุพรบ.</th>
                                            <th>แก้ไข</th>
                                            <th>ลบ</th>
                                            </thead>
                                            <tbody>
                                                @if(count($car)>0)
                                                @foreach($car as $c)
                                                 <?php 
                                                    $util = new Util;
                                                    $dateExp = $util->DateConvertToView($c->car_act_exp);
                                                ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{$c->car_no}}</td>
                                                    <td>{{$c->car_province}}</td>
                                                    <td>{{$c->car_type}}</td>
                                                    <td>{{$c->car_dept}}</td>
                                                    <td>{{$c->car_color}}</td>
                                                   
                                                    <td>{{$dateExp}}</td>
                                                    <td><a href="{{url("manage/car/update/$c->id")}}">แก้ไข</a></td>
                                                    <td><a href="{{url("manage/car/delete/$c->id")}}">ลบ</a></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{$car->links()}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop