@extends('default')
@section('brand')
บันทึกการซ่อมบำรุงรภ
@stop
@section('content')
    <?php 
        $disable="";
        if(Request::segment(3)=='update'){
        $disable =  (((Session::get('level') > 2) || (Auth::id()==$member->id))&& ($update==true)) ? '' : 'disabled style=background-color:#eee' ;    
        }
    ?>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <strong>ข้อมูลการซ่อมบำรุงรถ</strong>
                                <div class="pull-right">
                                    <a href="{{URL::to('manage/mainternance')}}" class="btn btn-default">กลับ</a>
                                </div>
                            </div>
                            <div class="content">
                                <form method="POST" name="form" data-toggle="validator" role="form">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label>หมายเลขทะเบียนรถ</label>
                                            <select class="form-control border-input" name="mn_car_id" {{$disable}}>
                                                @foreach($cars as $c)
                                                <option value="{{$c->id}}" {{(!empty($main->mn_car_id) && $main->mn_car_id==$c->id) ? 'selected' : ''}}>{{$c->car_no.' '.$c->car_province.' ('.$c->car_type.')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label>เลขระยะทางเมื่อเข้าซ่อม</label>
                                            <input type="text" class="form-control border-input" name="mn_car_dis" value="{{!empty($main->mn_car_dis) ? $main->mn_car_dis : ''}}" required {{$disable}}>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <?php 
                                            $util = new Util;
                                            ?>
                                            <label>วันที่บันทึก</label>
                                            <input type="text" id="dateSave" class="form-control border-input" name="mn_date_save" value="{{!empty($main->mn_date_save) ? $util->DateConvertToView($main->mn_date_save): ''}}" required {{$disable}}>
                                        </div>
                                         <div class="col-md-3 form-group">
                                            <label>ชื่อผู้บันทึก</label>
                                            <input type="text" class="form-control border-input" value="{{$member->mem_name.' '.$member->mem_lname}}" readonly {{$disable}}>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>รายละเอียดการซ่อม</label>
                                            <textarea rows="5" class="form-control border-input" name="mn_details" {{$disable}}>{{!empty($main->mn_details) ? $main->mn_details : '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>สถานที่ซ่อม</label>
                                            <textarea rows="5" class="form-control border-input" name="mn_shop" {{$disable}}>{{!empty($main->mn_shop) ? $main->mn_shop : '' }}</textarea>
                                        </div>
                                    </div>
                                    @if((Request::segment(2)=='mainternance')&&(Request::segment(3)=='create') && (empty($disable)))
                                    <div class="row">
                                            <div class="col-md-1">
                                                <input type="submit" class="btn btn-danger btn-block" value="บันทึก">
                                            </div>
                                            <div class="col-md-1">
                                                <input type="reset" class="btn btn-default btn-block" value="ล้าง">
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    @if((Request::segment(2)=='mainternance')&&(Request::segment(3)=='update'))
                                        
                                        <div class="row">
                                            <div class="header">
                                                @if(empty($disable))
                                                   <a href="#" data-toggle="modal" data-target="#ShowDetails"><i class="ti-pencil-alt2"></i>เพิ่มรายการซ่อม</a>
                                                @else
                                                   <i class="ti-pencil-alt2"></i>รายการซ่อม
                                                @endif
                                            </div>
                                        </div>
                                        
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><label>#</label></th>
                                                            <th><label>รายการ</th>
                                                            <th width="10%"><label>จำนวน</label></th>
                                                            <th width="20%"><label>ราคา/หน่วย บาท</label></th>
                                                            <th width="5%"><label>รวม</label></th>
                                                            <th width="5%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($detail)>0)
                                                            <?php $total=0; $cnt=1; ?>
                                                            @foreach($detail as $d)
                                                            <?php $sum =$d->mnd_qty*$d->mnd_baht; ?>
                                                            <tr>
                                                                <td>{{$cnt++}}</td>
                                                                <td>{{$d->mnd_list}}</td>
                                                                <td>{{$d->mnd_qty}}</td>
                                                                <td><?php echo number_format($d->mnd_baht,2); ?></td>
                                                                <td><?php echo number_format($sum,2); ?></td>
                                                                <td>
                                                                    @if(empty($disable))
                                                                        <a href="#" onclick="del({{$d->id}})"><i class="ti-trash"></i></a>
                                                                    @endif
                                                                </td>
                                                                
                                                            </tr>
                                                            <?php $total+=$sum; ?>
                                                            @endforeach
                                                        <tr>
                                                            <td colspan="4" style="text-align:right"> Vat 7%</td>
                                                            <?php $vat = $total*.07; ?>
                                                            <td colspan="3"><span id="sumVat"><?php echo number_format($vat,2); ?></span> บาท</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" style="text-align:right"><strong>รวมทั้งหมด</strong></td>
                                                            <td colspan="3"<span id="total"><?php echo number_format($total+$vat,2); ?></span>  บาท</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                      <input type="hidden" name="id" value="{{$main->id}}">
                                      @if(((Session::get('level')>2) || (Auth::id()==$member->id)))
                                        <div class="row">
                                            <div class="col-md-1">
                                                <input type="submit" class="btn btn-danger btn-block" value="บันทึก">
                                            </div>
                                            <div class="col-md-1">
                                                <input type="reset" class="btn btn-default btn-block" value="ล้าง">
                                            </div>
                                        </div>
                                      @endif
                                    @endif
                                 </form>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $('#dateSave').datetimepicker({
        format:'d-m-Y',
        timepicker:false,
        yearOffset:543
    });
    @if((Request::segment(2)=='mainternance')&&(Request::segment(3)=='update'))
    function del(id)
    {
        swal({title:'ต้องการลบข้อมูลหรือไม่' ,type: 'question',showCancelButton: true})
                .then(function(){
                     location.replace('{{URL::to("manage/mainternance/delete-list")}}/'+id);
                });
    }
    function save()
    {
        $.ajax({
          type: 'POST',
          url: '{{URL::to("manage/mainternance/update-list")}}',
          data:{id:'{{$main->id}}'
                ,mnd_list:$('#mnd_list').val()
                ,mnd_qty:$('#mnd_qty').val()
                ,mnd_baht:$('#mnd_baht').val()},
          success: function (data) {
                if(data=='success')
                {
                    swal({title:'เพิ่มข้อมูลเรียบร้อย' ,type: 'success'
                        ,showConfirmButton: false}),setTimeout(function()
                            {location=''},1000);
                }
            }
        });
    }
    @endif
   //Set DatetimePicker
   $.datetimepicker.setLocale('th');
   //Form Validator
   $('#form').validator();
</script>
@stop
@section('custom-detail')
<form method="POST" name="form" data-toggle="validator" role="form">
    <div class="modal fade" id="ShowDetails" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">เพิ่มรายการซ่อมรถ</h4>
          </div>
          <div class="modal-body">
              <table class="table">
                <tr>
                    <td>รายการ</td>
                    <td><div class="form-group"><input type="text" id="mnd_list" name="mnd_list" class=" form-control border-input" value="" required></div></td>
                </tr>
                 <tr>
                    <td>จำนวน</td>
                    <td><div class="form-group"><input type="text" id="mnd_qty" name="mnd_qty" class="form-control border-input" value="" required></div></td>
                </tr>
                 <tr>
                    <td>ราคา</td>
                    <td><div class="form-group"><input type="text" id="mnd_baht" name="mnd_baht" class="form-control border-input" value="" required></div></td>
                </tr>
              </table>
          </div>
          <div class="modal-footer">
                <div class="col-md-3">  
                    <input type="button" name="" class="btn btn-danger btn-block" onclick="save()" value="บันทึก">
                </div>
          </div>
        </div>
      </div>
    </div>
</form>
@stop
@section('costom-style')
   <!--JS IN HEAD-->
   <!--datetimepicker-->
        <link rel="stylesheet" type="text/css" href="{{URL::to('assets/datetimepicker/jquery.datetimepicker.css')}}" >
        <script src="{{URL::to('assets/datetimepicker/jquery.js')}}"></script>
        <script src="{{URL::to('assets/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>
    <!--validations-->
        <script src="{{URL::to('assets/validator/js/validator.js')}}"></script>
@stop