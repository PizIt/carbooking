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
                                              <a href="{{url('manage/member/create')}}" class="btn btn-info">เพิ่มข้อมูลสมาชิก</a>
                                          </div>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>#</th>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>ตำแหน่ง</th>
                                            <th>กอง</th>
                                            <th>เบอร์โทร</th>
                                            <th>ระดับสมาชิก</th>
                                            <th>แก้ไข</th>
                                            <th>ลบ</th>
                                            </thead>
                                            <tbody>
                                                @if(count($member)>0)
                                                <?php 
                                                $currentPage = $member->getCurrentPage();
                                                $perPage = $member->getPerPage();
                                                $cnt = 1;
                                                ?>
                                                @foreach($member as $m)
                                                
                                                <?php 
                                                $position=$m->mem_level;
                                                if($position==1)
                                                {
                                                    $position="พนักงานขับรถ";
                                                }elseif ($position==2)
                                                {
                                                    $position="ผู้ขอใช้รถ";
                                                }elseif ($position==3)
                                                {
                                                    $position="ผู้อำนวยการกอง";
                                                }
                                                else{
                                                    $position="หัวหน้าสำนักปลัด";
                                                }
                                            
                                                ?>
                                                <tr>
                                                    <td>{{$cnt++}}</td>
                                                    <td>{{$m->mem_name." ".$m->mem_lname }}</td>
                                                    <td>{{$m->mem_position}}</td>
                                                    <td>{{$m->mem_dept}}</td>
                                                    <td>{{$m->mem_tel}}</td>
                                                    <td><?=$position?></td>
                                                    <td><a href="{{url("manage/member/update/$m->id")}}">แก้ไข</a></td>
                                                    <td><a href="{{url("manage/member/delete/$m->id")}}">ลบ</a></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{$member->links()}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop