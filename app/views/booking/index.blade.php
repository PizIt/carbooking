@extends('default')
@section('brand')
จองรถ
@stop
@section('content')  
  <div class="content">
            <div class="container-fluid">   
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                                <div class="header">
                                    <strong>รายละเอียดการจอง</strong>
                                </div>
                                <div class="content">
                                    <form  method="POST" id="form" name="form" data-toggle="validator" role="form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ชื่อผู้จอง</label>
                                                    <input type="text" class="form-control border-input"  value="{{$member->mem_name." ".$member->mem_lname}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ตำแหน่ง</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_position}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control border-input" value="{{$member->mem_tel}}" disabled style="background-color: #eee">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ประเภท</label>
                                                    <select class="form-control border-input" name="book_type">
                                                        <option value="ในเขตพื้นที่">ในเขตพื้นที่</option>
                                                        <option value="นอกเขตพื้นที่">นอกเขตพื้นที่</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>วันเวลาที่เดินทาง</label>
                                                    <input type="text" id="dateStart" name="book_date_from"  class="form-control border-input" placeholder="dd-MM-YYYY HH:ii" value="" required>
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>ถึงวันที่</label>
                                                    <input type="text" id="dateEnd" name="book_date_to" class="form-control border-input" placeholder="dd-MM-YYYY HH:ii" value="" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>ใช้เพื่อ</label>
                                                    <input  type="text" name="book_for" class="form-control border-input" placeholder="จุดประสงค์การใช้งาน" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>สถานที่เดินทาง </label>
                                                    <input type="text" name="book_location" class="form-control border-input" placeholder="ไปที่ไหน" required>
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
                                                    <textarea  rows="5" id="details" name="book_details" class="form-control border-input"></textarea>
                                                </div>
                                            </div>
                                        </div>                                       
                                        <div class="row" id="listFree" hidden>
                                            <!--Content Cars&Drivers-->
                                        </div>
                                        <input type="hidden" name="lat" id="lat">
                                         <input type="hidden" name="lon" id="lng">
                                        <div class="text-center">
                                            <input type="submit" value="จองรถ" onclick="return check()" class="btn btn-danger btn-fill btn-wd">
                                        </div>
                                    </form>
                                </div>
                           </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    function check()
    {
      var carsID = $("input:checkbox:checked.chkcar").map(function(){
          return this.value;
      }).get();
      var driversID = $("input:checkbox:checked.chkdriver").map(function(){
          return this.value;
      }).get();
      var cntCar = carsID.length;
      var cntDriver = driversID.length;
      //count check drivers ans cars
      if((cntCar > 0) && (cntDriver > 0))
      {
        return true;
      }else
      {
          swal({title:'ผิดพลาด',text:'โปรดตรวจสอบรายการที่จอง',type:'error'});   
          return false;
           
      }
    }
    // set datetime default
    var dateNow = new Date();
    var dateTimeNow = dateNow.getDay()+'-'+dateNow.getMonth()+'-'+dateNow.getFullYear();
        dateTimeNow += ' '+dateNow.getHours()+':'+dateNow.getMinutes();
    $('#dateStart').datetimepicker({
        minDate: dateTimeNow,
        format:'d-m-Y H:i',
        yearOffset:543
    });
    $('#dateEnd').datetimepicker({
        minDate:dateTimeNow,
        format:'d-m-Y H:i',
        yearOffset:543
    }); 
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
    $(document).ready(function(){
	$("#dateStart").blur(function(){
            var dateStart = $("#dateStart").val();
            var dateEnd = $("#dateEnd").val();
            $.list(dateStart,dateEnd); 
	});
        $("#dateEnd").blur(function(){
            var dateStart = $("#dateStart").val();
            var dateEnd = $("#dateEnd").val();
            $.list(dateStart,dateEnd); 
	});
        $.list = function(dateStart,dateEnd){
          if((dateStart!="")&&(dateEnd!="")){
                    // Select Car And Driver 
                    $.ajax({
                       type: 'get' ,
                       async: false,
                       url: "booking/car-and-driver?dateStart="+dateStart+"&dateEnd="+dateEnd,
                       success: function (data) {
                           if(data!='false')
                           {
                                $("#listFree").html(data);
                                $("#listFree").fadeIn('slow');
                           }
                           else
                           {
                                $("#listFree").html('');
                                $("#listFree").fadeOut('slow');
                           }
                        }
                    });
          }
        } 
        
    });
    window.onload= function(){
        $('#rowMap').hide();
    } 
       function initMap() {
          var lat = 17.485257695007665;
          var lng = 101.73062393839837;
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