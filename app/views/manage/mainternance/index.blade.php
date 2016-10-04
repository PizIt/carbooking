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
                                              <a href="{{url('manage/mainternance/create')}}" class="btn btn-info">เพิ่มข้อมูลรถ</a>
                                          </div>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                            <td style="text-align:center">#</td>
                                            <td><label>วันที่บันทึก</label></td>
                                            <td><label>รถที่เข้าซ่อม</label></td>
                                            <td><label>ผู้บันทึก</label></td>
                                            <td><label>ร้านซ่อม</label></td>
                                            <td><label>ค่าใช้จ่าย</label></td>
                                            <td><label>แก้ไข</label></td>
                                            <td><label>ลบ</label></td>
                                            </thead>
                                            <tbody>
                                                @if(count($list)>0)
                                                <?php $cnt = 1;?>
                                                @foreach($list as $l)
                                                <tr>
                                                    <td style="text-align:center">{{$cnt++;}}</td>
                                                    <td>{{$l[0];}}</td>
                                                    <td>{{$l[1];}}</td>
                                                    <td>{{$l[2];}}</td>
                                                    <td>{{$l[3];}}</td>
                                                    <td>{{$l[4];}}</td>
                                                    <td><a href="{{url("manage/mainternance/update/$l[5]")}}">แก้ไข</a></td>
                                                    <td><a href="#" onclick="del({{$l[5]}})">ลบ</a></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{$main->links();}}
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
                 location.replace('{{URL::to("manage/mainternance/delete")}}/'+id);
            });
    }
</script>
@stop