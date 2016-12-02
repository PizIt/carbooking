@extends('default')
@section('brand')
  @if(Session::get('level')>2)
        จัดการข้อมูลสมาชิก
    @else
        ข้อมูลสมาชิก
    @endif
@stop
@section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-7">
                                        <form method="GET" class="form-inline">
                                             <div class="form-group">
                                                 <label>เรียงตาม</label>
                                                 <select class="form-control border-input" name="level">
                                                     <option value="">ทั้งหมด</option>
                                                     <option value="2" {{Input::get('level')=='2' ? 'selected' : ''}}>ผ้ขอใช้รถ</option>
                                                     <option value="1" {{Input::get('level')=='1' ? 'selected' : ''}}>พนักงานขับรถ</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                 <input type="submit" class="btn btn-danger btn-block" value="แสดงข้อมูล">
                                              </div>
                                         </form>
                                     </div>
                                     @if(Session::get('level')>2)
                                         <div class="col-md-5">
                                                <div class="pull-right">
                                                    <a href="{{url('manage/member/create')}}" class="btn btn-default">
                                                        <i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูลสมาชิก
                                                    </a>
                                               </div>
                                         </div>
                                     @endif
                                    </div>
                                    <hr>
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
                                                            elseif($position==4){
                                                                $position="ปลัด/นายก";
                                                            }

                                                        ?>
                                                        <tr>
                                                            <td>{{++$cnt;}}</td>
                                                            <td>{{$m->mem_name." ".$m->mem_lname }}</td>
                                                            <td>{{$m->mem_position}}</td>
                                                            <td>{{$m->mem_dept}}</td>
                                                            <td>{{$m->mem_tel}}</td>
                                                            <td><?=$position?></td>
                                                            <td style="text-align:left">
                                                                <a href="{{url("manage/member/update/$m->id")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                @if(Session::get('level') > 2 && Session::get('level') >= $m->mem_level && Auth::id()!=$m->id && Session::get('dept')==$m->mem_dept)
                                                                <a href="#" onclick="del({{$m->id}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                                @endif
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
