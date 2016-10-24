@extends('default')
@section('brand')
รายการจองรถ
@stop
@section('content')  
  <div class="content">
            <div class="container-fluid">                  
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="header">
                                   <strong>รายละเอียดการจองรถ</strong>
                                </div>
                                <div class="content">
                                    <form method="POST" name="form" data-toggle="validator" role="form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ชื่อผู้จอง</label>
                                                    <input type="text" class="form-control border-input"  value="{{$member->mem_name." ".$member->mem_lname}}" disabled style="background-color:#eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_position}}" disabled style="background-color:#eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_tel}}" disabled style="background-color:#eee">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ประเภท</label>
                                                    <select class="form-control border-input" name="book_type" disabled style="background-color:#eee">
                                                        <option value="ในเขตพื้นที่" {{!empty($booking->book_type=='ในเขตพื้นที่')?'selected':''}}>ในเขตพื้นที่</option>
                                                        <option value="นอกเขตพื้นที่" {{!empty($booking->book_type=='นอกเขตพื้นที่')?'selected':''}}>นอกเขตพื้นที่</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันเวลาที่เดินทาง</label>
                                                    <?php 
                                                    $util = new Util;
                                                    $dateStart = $util->DateTimeConvertToView($booking->book_date_from) ;      
                                                    $dateEnd = $util->DateTimeConvertToView($booking->book_date_to) ;
                                                    ?>
                                                    <input type="text" id="dateStart" name="book_date_from"  class="form-control border-input" placeholder="dd/MM/YYYY HH:ii" value="{{substr($dateStart,0,16)}}" readonly style="background-color:#eee">
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่</label>
                                                    <input type="text" id="dateEnd" name="book_date_to" class="form-control border-input" placeholder="dd/MM/YYYY HH:ii" value="{{substr($dateEnd,0,16)}}" readonly style="background-color:#eee">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ใช้เพื่อ</label>
                                                    <input type="text" name="book_for" class="form-control border-input" placeholder="จุดประสงค์การใช้งาน" required value="{{$booking->book_for}}" 
                                                           {{((Auth::id()==$booking->book_mem_id) || (Session::get('level')>2)) ? '' : 'disabled style="background-color:#eee"'}}>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>สถานที่เดินทาง</label>
                                                    <input type="text" name="book_location" class="form-control border-input" placeholder="ไปที่ไหน" required value="{{$booking->book_location}}"
                                                            {{((Auth::id()==$booking->book_mem_id) || (Session::get('level')>2)) ? '' : 'disabled style="background-color:#eee"'}}>
                                                </div>
                                            </div>
                                        </div>
                                            <a href="#" id="openMap">แสดงแผนที่</a>
                                            <div class="card-map" id="rowMap">
                                                <div class="header">
                                                    <h4 class="title">Google Maps</h4>
                                                </div>
                                                <div class="map">
                                                    <div id="map"></div>
                                                </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>รายละเอียดเพิ่มเติม</label>
                                                    <textarea rows="5" name="book_details" class="form-control border-input"
                                                               {{((Auth::id()==$booking->book_mem_id) || (Session::get('level') > 2)) ? '' : 'disabled style="background-color:#eee"'}}>{{$booking->book_details}}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="row">
                                        <div class="col-md-6">
                                            <div class="header">
                                                <strong>รายการรถที่จอง</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <tr>
                                                    <th>#</th>
                                                    <th>รูปรถ</th>
                                                    <th>ป้ายทะเบียน</th>
                                                    <th>ประเภท</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php $cnt=0;?>
                                                        @foreach($carBook as $c)
                                                        <tr>
                                                            <td><?=++$cnt?></td>
                                                            <td><img src="{{URL::to('img/cars/'.$c->car_pic.'')}}" class="img-rounded" width="80px" height="80px"></td>
                                                            <td>{{$c->car_no.' '.$c->car_province}}</td>
                                                            <td>{{$c->car_type}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="header">
                                                <strong>พนักงานขับรถที่จอง</strong>
                                            </div>
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <tr>
                                                    <th>#</th>
                                                    <th>รูป</th>
                                                    <th>ชื่อพนักงงานขับรถ</th>
                                                    </tr>
                                                    <tbody>
                                                        <?php $cnt=0;?>
                                                        @foreach($driverBook as $d)
                                                        <tr>
                                                            <td><?=++$cnt?></td>
                                                            <td><img src="{{URL::to('img/members/'.$d->mem_pic.'')}}"  class="img-rounded"  width="80px" height="80px"></td>
                                                            <td>{{$d->mem_name.' '.$d->mem_lname}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                               
                                            </div>
                                        </div>
                                    </div>
                                       
                                        <hr>
                                       <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped">
                                                <tr style="text-align:center">
                                                    <td colspan="2"><strong>ความเห็นของหัวหน้าสำนักปลัด</strong></td>
                                                    @if($booking->book_type=='นอกเขตพื้นที่')
                                                    <td colspan="2"><strong>ความเห็นของนายกเทศมนตรี</strong></td>  
                                                    @endif
                                                </tr>
                                                <tr style="text-align:center">
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_leader" value="2" 
                                                                   {{$booking->book_confirm >= 2  ? 'checked' : ''}} {{((Session::get('level') >= 3)&&(Session::get('dept')=='สำนักปลัด')) ? '':'disabled'}}>
                                                            <strong class="text-success">อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    <td style="width:25%">
                                                        <label>
                                                                <input type="radio" class="border-input" name="confirm_leader" value="-1" 
                                                                    {{$booking->book_confirm == 0  ? 'checked' : ''}} {{((Session::get('level') >= 3)&&(Session::get('dept')=='สำนักปลัด'))  ? '':'disabled'}}>
                                                            <strong class="text-danger">ไม่อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    @if($booking->book_type=='นอกเขตพื้นที่')
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_master" value="3" 
                                                                   {{$booking->book_confirm ==3  ? 'checked' : ''}} {{Session::get('level')==4 ? '':'disabled'}}>
                                                            <strong class="text-success">อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                    <td style="width:25%">
                                                        <label>
                                                            <input type="radio" class="border-input" name="confirm_master" value="-1" 
                                                                   {{$booking->book_confirm == 0  ? 'checked' : ''}} {{Session::get('level')==4 ? '':'disabled'}}>
                                                            <strong class="text-danger">ไม่อนุญาต</strong>
                                                        </label>
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr style="text-align:left">
                                                    <td style="width:50%" colspan="2">
                                                        <label>
                                                            <strong>{{!empty($leader) ? $leader->mem_name.' '.$leader->mem_lname.' : '.$leader->mem_position : ''}}</strong>
                                                        </label>
                                                    </td>
                                                    @if($booking->book_type=='นอกเขตพื้นที่')
                                                      <td style="width:50%" colspan="2">
                                                        <label>
                                                            <strong>{{!empty($master) ? $master->mem_name.' '.$master->mem_lname.' : '.$master->mem_position : ''}}</strong>
                                                        </label>
                                                    </td>
                                                    @endif
                                                </tr>
                                                 <tr style="text-align:center">
                                                     <td colspan="2"><strong>หมายเหตุ  </strong>
                                                            <input type="text" name="book_note_leader" class="form-control border-input" placeholder="หมายเหตุ" 
                                                                   value="{{!empty($booking->book_note_leader) ? $booking->book_note_leader : ''}}" {{((Session::get('level') >= 3)&&(Session::get('dept')=='สำนักปลัด'))  ? '':'readonly style="background-color:beige;"'}}>
                                                     </td>
                                                      @if($booking->book_type=='นอกเขตพื้นที่')
                                                     <td colspan="2"><strong>หมายเหตุ  </strong>
                                                            <input type="text" name="book_note_master" class="form-control border-input" placeholder="หมายเหตุ" 
                                                                   value="{{!empty($booking->book_note_master) ? $booking->book_note_master : ''}}" {{Session::get('level')==4 ? '':'readonly style="background-color:beige;"'}}>
                                                     </td> 
                                                     @endif
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lat" id="lat" value="{{!empty($booking->book_gps_lat) ? $booking->book_gps_lat:''}}">
                                        <input type="hidden" name="lng" id="lng" value="{{!empty($booking->book_gps_lon) ? $booking->book_gps_lon:''}}">
                                        <input type="hidden" name="id" value="{{$booking->id}}">
                                        @if((Auth::id()==$booking->book_mem_id) || (Session::get('level') > 2))
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-danger btn-fill btn-wd">บันทึก</button>
                                        </div>
                                        @endif
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                           </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
  $('#openMap').click(function(){
    if($('#openMap').text()=='แสดงแผนที่')
    {
        $( "#rowMap" ).fadeIn( "slow");
        $('#openMap').text('ซ่อนแผนที่');
    }else
    {
         $( "#rowMap" ).fadeOut( "slow");
         $('#openMap').text('แสดงแผนที่');
    }
})
 window.onload= function(){
        $('#rowMap').hide();
    } 
       function initMap() {
          var latDefault = 17.485257695007665;
          var lngDefault = 101.73062393839837;
          var lat = {{!empty($booking->book_gps_lat) ? $booking->book_gps_lat : '17.485257695007665'}};
          var lng = {{!empty($booking->book_gps_lon) ? $booking->book_gps_lon : '101.73062393839837'}};
          var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: lat, lng: lng},
            zoom: 15
          });
          var marker = new google.maps.Marker ({map:map,draggable:true,
              animation:google.maps.Animation.BOUNCE,
              position : {lat: lat, lng: lng}
          });
        //get lat&lan
        marker.addListener('dragend',function(){
            var position = marker.getPosition();
            $('#lat').val(position.lat());
            $('#lng').val(position.lng());
        });
        } 
    //Set DatetimePicker
    $.datetimepicker.setLocale('th');
    //Form Validator
    $('#form').validator();
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAt7OP8jq0nhzMKFqd7AIKTvU_4N43_81M&callback=initMap"async defer></script>
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