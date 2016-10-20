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
                                        @if(Session::get('level')==1)
                                            <div class="header">
                                                  <div class="pull-right">
                                                      <a href="{{url('manage/mainternance/create')}}" class="btn btn-default">เพิ่มข้อมูลรถ</a>
                                                  </div>
                                            </div>
                                        @endif
                                        <div class="content table-responsive table-full-width">
                                            <table class="table table-striped">
                                                <thead>
                                                    <td style="text-align:center"><label>#</label></td>
                                                    <td><label>วันที่บันทึก</label></td>
                                                    <td><label>รถที่เข้าซ่อม</label></td>
                                                    <td><label>ผู้บันทึก</label></td>
                                                    <td><label>ร้านซ่อม</label></td>
                                                    <td style="text-align: center"><label>ค่าใช้จ่าย</label></td>
                                                    <td><label>จัดการ</label></td>
                                                </thead>
                                                <tbody>
                                                    @if(count($list)>0)
                                                        <?php   $currentPage=$main->getCurrentPage();
                                                                $perPage = $main->getPerPage();
                                                                $cnt = ($currentPage*$perPage)-$perPage;
                                                        ?>
                                                        @foreach($list as $l)
                                                            <tr>
                                                                <td style="text-align:center">{{++$cnt}}</td>
                                                                <td>{{$l[0];}}</td>
                                                                <td>{{$l[1];}}</td>
                                                                <td>{{$l[2];}}</td>
                                                                <td>{{$l[3];}}</td>
                                                                <td style="text-align: right">{{$l[4];}}</td>
                                                                <td style="text-align:left">
                                                                    <a href="{{url("manage/mainternance/update/$l[5]")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                    @if(($l[6]==Auth::id())||(Session::get('level')>2))
                                                                    <a href="#" onclick="del({{$l[5]}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                             <center>
                                                {{$main->links();}}
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
                 location.replace('{{URL::to("manage/mainternance/delete")}}/'+id);
            });
    }
</script>
@stop