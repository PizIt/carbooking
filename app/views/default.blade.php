<!doctype html>
<html lang="en">
@section('costom-html')
@show
<!--Login -->
  @if(!Auth::check())
   <link rel="stylesheet" href="{{URL::to('assets/login/login.css')}}">
   <div class="modal fade" id="ShowFormLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
               	<h1>Login to Your Account</h1><br>
          <form>
                <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                <input type="password" name="password" id="password" placeholder="Password" class="form-control">
		<input type="button" name="login" id="login" class="btn-block login loginmodal-submit" value="Login">
          </form>
        </div>
    </div>
</div>
  @endif
<head>
    <meta charset="utf-8" name="csrf-token" content="{{csrf_token()}}"/>

    <link rel="apple-touch-icon" sizes="76x76" href="{{URL::to('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{URL::to('assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    

    <title>ระบบจองรถยนต์เทศบาลเมืองเลย</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <!--    <link href="{{URL::to('assets/css/bootstrap.min.css')}}" rel="stylesheet" />-->
     <link href="{{URL::to('assets/bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <!--    <link href="{{URL::to('assets/css/animate.min.css')}}" rel="stylesheet"/>-->

    <!--  Paper Dashboard core CSS    -->
    <link href="{{URL::to('assets/css/paper-dashboard.css')}}" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{URL::to('assets/css/themify-icons.css')}}" rel="stylesheet">
    <!-- DateTimepicker -->        
        <link rel="stylesheet" type="text/css" href="{{URL::to('assets/datetimepicker/jquery.datetimepicker.css')}}" >
        <script src="{{URL::to('assets/datetimepicker/jquery.js')}}"></script>
        <script src="{{URL::to('assets/datetimepicker/build/jquery.datetimepicker.full.min.js')}}"></script>
     <!--End DateTimepicker--> 

    <!-- Validator -->
        <script src="{{URL::to('assets/validator/js/validator.js')}}"></script>
    <!-- End Validator -->   
    @section('costom-style') @show
   
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

    <!--
		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
	-->

    	<div class="sidebar-wrapper">
            <div class="logo">
               <center> <img src="{{URL::to('assets/pic/logo.png')}}" width="200px" height="190px"></center>
            </div>

            <ul class="nav">
                <li class="{{Request::segment(1)=="home"?'active':''}}">
                    <a href="{{url('home')}}">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <p style="font-family:TH SarabunPSK;font-size:16px;">ปฏิธินการใช้รถ</p>
                    </a>
                </li>
                @if(Auth::check())
                    @if(Session::get('level')!=1)
                    <li class="{{Request::segment(1)=="booking"?'active':''}}">
                        <a href="{{url('booking')}}">
                            <i class="ti-car"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">จองรถ</p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('level')!=2)
                    <li class="{{Request::segment(1)=="listbooking"?'active':''}}">
                        <a href="{{url('listbooking')}}">
                            <i class="ti-view-list-alt"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">รายการจองรถ</p>
                        </a>
                    </li>
                    <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="member"))?'active':''}}">
                        <a href="{{url('manage/member')}}">
                            <i class="glyphicon glyphicon-user"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">จัดการข้อมูลสมาชิก</p>
                        </a>
                    </li>
                       <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="usability"))?'active':''}}">
                        <a href="{{url('manage/usability')}}">
                            <i class="glyphicon glyphicon-dashboard"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">บันทึกการใช้รถ</p>
                        </a>
                    </li>
                          <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="pickup"))?'active':''}}">
                        <a href="{{url('manage/pickup')}}">
                            <i class="glyphicon glyphicon-oil"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">บันทึกการเบิกน้ำมัน</p>
                        </a>
                    </li>
                         <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="mainternance"))?'active':''}}">
                        <a href="{{url('manage/mainternance')}}">
                            <i class="ti-truck "></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">บันทึกการซ่อมบำรุงรถ</p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('level')>2)
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='booking') ?'active':''}}">
                        <a href="{{url('report/booking')}}">
                            <i class="ti-map"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">รายงานการจองรถ</p>
                        </a>
                    </li>
                    <li  class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='usability')?'active':''}}">
                        <a href="{{url('report/usability')}}">
                            <i class="glyphicon glyphicon-scale"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">รายงานการใช้งานรถ</p>
                        </a>
                    </li>
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='pickup')?'active':''}}">
                        <a href="{{url('report/pickup')}}">
                            <i class="ti-paint-bucket"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">รายงานการเบิกน้ำมัน</p>
                        </a>
                    </li>
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='mainternance')?'active':''}}">
                        <a href="{{url('report/mainternance')}}">
                            <i class="ti-settings"></i>
                            <p style="font-family:TH SarabunPSK;font-size:16px;">รายงานการซ่อมบำรุง</p>
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="font-family:TH SarabunPSK;font-size:40px;">
                        @if(Request::segment(1)=='home')
                            ปฏิธินการใช้รถ
                        @elseif(Request::segment(1)=='member')
                            ข้อมูลส่วนตัว
                        @elseif(Request::segment(1)=='booking')
                            จองรถ
                        @elseif(Request::segment(1)=='listbooking')
                            รายการจองรถ
                        @elseif((Request::segment(1)=='manage')&&(Request::segment(2)=='member'))
                            จัดการข้อมูลสมาชิก
                        @elseif((Request::segment(1)=='manage')&&(Request::segment(2)=='car'))
                            จัดการข้อมูลรถ
                        @elseif((Request::segment(1)=='manage')&&(Request::segment(2)=='usability'))
                            บันทึกการใช้งานรถ
                        @elseif((Request::segment(1)=='manage')&&(Request::segment(2)=='pickup'))
                            บันทึกการเบิกน้ำมัน
                        @elseif((Request::segment(1)=='manage')&&(Request::segment(2)=='mainternance'))
                            บันทึกการซ่อมบำรุงรภ
                        @endif
                        @section('brand')@show
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           @if(Auth::check())
                            <a href="{{URL::to('member')}}"  style="font-family:TH SarabunPSK;font-size:20px;">
                                <i class="ti-user"></i>
                                <p>{{Session::get('name')}}</p>
                            </a>
                        </li>
                            @if((Session::get('level')!=2)&&(Session::get('notification')>0))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" id="notification" data-toggle="dropdown" style="font-family:TH SarabunPSK;font-size:20px;">
                                    <i class="ti-bell"></i>
                                    <p class="notification">{{Session::get('notification')}}</p>
                                    <p>การแจ้งเตือน</p>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" id="listNotification">
                                     <!-- notification-->
                                </ul>
                            </li>
                            @endif
                            
                        <li>
                            <a href="{{URL::to('login/logout')}}" style="font-family:TH SarabunPSK;font-size:20px;">
                                <i class="ti-agenda"></i>
                                <p>ออกจากระบบ</p>
                            </a>
                        </li>
                         @else
                         <li>
                            <a href="#" data-toggle="modal" data-target="#ShowFormLogin" style="font-family:TH SarabunPSK;font-size:20px;">
                                <i class="ti-key"></i>
                                <p>เข้าสู่ระบบ</p>
                            </a>
                        </li>
                         @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!--content-->       
            @yield('content')
        <!--end content-->

         <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>

                        <li>
                            <a href="http://www.creative-tim.com">
                                Creative Tim
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                               Blog
                            </a>
                        </li>
                        <li>
                            <a href="http://www.creative-tim.com/license">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
                </div>
            </div>
        </footer>    
    </div>
</div> 
@section('custom-detail') @show <!-- // show custom Detai-->
@if(Session::has('message'))
        <!--Show Message In Controller-->
        <script type="text/javascript">
            window.onload = function(){
                swal({title:'{{Session::get("message")}}',type:'success'});
            }
        </script>
@endif 
<script type="text/javascript">
   //Set DatetimePicker
   $.datetimepicker.setLocale('th');
   //Form Validator
   $('#form').validator();
   //Notifications
   $('#notification').click(function(){
       $.ajax({
           async: true,
           type: 'get',
           url:"{{URL::to('notification')}}",
           success: function (data){
                      $('#listNotification').html(data);
                    }
       });
   });
</script>
</body>

    <!--   Core JS Files   -->
    <script src="{{URL::to('assets/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
    <!--   <script src="{{URL::to('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>-->
    
    <!--  Notifications Plugin    -->
    <script src="{{URL::to('assets/js/bootstrap-notify.js')}}"></script>
     @section('costom-js') @show   
    <!-- Sweetalert -->
        <script src="{{URL::to('assets/sweetalert2/sweetalert2.min.js')}}"></script>
        <link rel="stylesheet" href="{{URL::to('assets/sweetalert2/sweetalert2.min.css')}}">
    <!-- End Sweetalert -->
    <!-- Bootstrap -->
        <script src="{{URL::to('assets/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>      
    <!-- End Bootstrap -->
    
    <!--     Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{URL::to('assets/js/paper-dashboard.js')}}"></script>
  @if(!Auth::check())
    <script src="{{URL::to('assets/login/login.js')}}"></script>
  @endif
</html>

