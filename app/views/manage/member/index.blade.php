@extends('default')
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
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
                                                <th style="text-align:center"><label>#</label></th>
                                                    <th><label>ชื่อ - นามสกุล</label></th>
                                                    <th><label>ตำแหน่ง</label></th>
                                                    <th><label>กอง</label></th>
                                                    <th><label>เบอร์โทร</label></th>
                                                    <th><label>ระดับสมาชิก</label></th>
                                                    <th style="text-align:center"><label>จัดการ</label></th>
                                                </thead>
                                                <tbody>
                                                    @if(count($member)>0)
                                                        <?php 
                                                            $currentPage = $member->getCurrentPage();
                                                            $perPage = $member->getPerPage();
                                                            $cnt = ($currentPage*$perPage)-$perPage;
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
                                                            <td>{{++$cnt;}}</td>
                                                            <td>{{$m->mem_name." ".$m->mem_lname }}</td>
                                                            <td>{{$m->mem_position}}</td>
                                                            <td>{{$m->mem_dept}}</td>
                                                            <td>{{$m->mem_tel}}</td>
                                                            <td><?=$position?></td>
                                                            <td style="text-align:center">
                                                                <a href="{{url("manage/member/update/$m->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                <a href="#" onclick="del({{$m->id}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <center>
                                                {{$member->links()}}
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
    function del(id)
    {
    swal({title:'ต้องการลบข้อมูลหรือไม่' ,type: 'question',showCancelButton: true})
            .then(function(){
                 location.replace('{{URL::to("manage/member/delete")}}/'+id);
            });
    }
</script>
@stop
