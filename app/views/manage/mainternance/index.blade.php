@extends('default')
@section('brand')
บันทึกการซ่อมบำรุงรภ
@stop
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
                                            <div class="row">
                                                <div class="header">
                                                      <div class="pull-right">
                                                          <a href="{{url('manage/mainternance/create')}}" class="btn btn-default">เพิ่มข้อมูลรถ</a>
                                                      </div>
                                                </div>
                                            </div>
                                        <hr>
                                        @endif
                                        <div class="content table-responsive table-full-width">
                                               <table class="table table-bordered table-striped" border="0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" width="5%" style="text-align:center"><label>#</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>วันที่ซ่อม</label></th>
                                                            <th colspan="3" width="20%" style="text-align:center"><label>ข้อมูลรถที่ซ่อม</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>กอง</label></th>
                                                            <th rowspan="2" width="10%" style="text-align:center"><label>จำนวนเงิน</label></th>
                                                            <th rowspan="2" width="7%" style="text-align: center"><label>จัดการ</label></th>
                                                        </tr>
                                                        <tr>
                                                            <th width="15%" style="text-align:center"><label>ทะเบียนรถ</label></th>
                                                            <th width="10%" style="text-align:center"><label>ประเภท</label></th>
                                                            <th width="10%" style="text-align:center"><label>ชื่อผู้บันทึก</label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($list)>0)
                                                           <?php
                                                                $currentPage=$main->getCurrentPage();
                                                                $perPage = $main->getPerPage();
                                                                $cnt = ($currentPage*$perPage)-$perPage;
                                                            ?>
                                                            @foreach($list as $l)
                                                                <tr>
                                                                    <td style="text-align: center">{{++$cnt}}</td>
                                                                    <td><a href="#">{{$l[0];}}</a></td>
                                                                    <td>{{$l[1];}}</td>
                                                                    <td>{{$l[2];}}</td>
                                                                    <td>{{$l[3];}}</td>
                                                                    <td>{{$l[4];}}</td>                                                          
                                                                    <td style="text-align:right">{{number_format($l[5]);}}</td>
                                                                    <td style="text-align:left">
                                                                        <a href="{{url("manage/mainternance/update/$l[7]")}}"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;
                                                                        @if(($l[6]==Auth::id())||(Session::get('level')>2))
                                                                        <a href="#" onclick="del({{$l[7]}})"> <i class="glyphicon glyphicon-trash"></i></a>&nbsp;
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