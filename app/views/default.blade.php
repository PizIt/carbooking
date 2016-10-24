<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" name="csrf-token" content="{{csrf_token()}}"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{URL::to('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{URL::to('assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <title>ระบบจองรถยนต์เทศบาลเมืองเลย</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{URL::to('assets/bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link href="{{URL::to('assets/css/paper-dashboard.css')}}" rel="stylesheet"/>

    <!--  Fonts and icons     -->
    <link href="{{URL::to('assets/css/themify-icons.css')}}" rel="stylesheet">
    <!--   Core JS Files   -->
    <script src="{{URL::to('assets/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
       <!--  Notifications Plugin    -->
    <!--<script src="{{URL::to('assets/js/jquery-1.10.2.js')}}"></script>-->
    <link href="{{URL::to('assets/css/animate.min.css')}}" rel="stylesheet"/>
    @section('costom-style') @show
     <!--Login -->
    @if(!Auth::check())
      <link href="{{URL::to('assets/login/login.css')}}" rel="stylesheet" />
     <?php include('assets/login/login.html')?>
    @endif
    @section('costom-html')@show
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">
    	<div class="sidebar-wrapper">
            <div class="logo">
               <center> <img src="{{URL::to('assets/pic/logo.png')}}" width="200px" height="190px"></center>
            </div>

            <ul class="nav">
                <li class="{{Request::segment(1)=="home"?'active':''}}">
                    <a href="{{url('home')}}">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <p style="font-size:16px;">ปฏิธินการใช้รถ</p>
                    </a>
                </li>
                @if(Auth::check())
                    @if(Session::get('level')!=1)
                    <li class="{{Request::segment(1)=="booking"?'active':''}}">
                        <a href="{{url('booking')}}">
                            <i class="ti-car"></i>
                            <p style="font-size:16px;">จองรถ</p>
                        </a>
                    </li>
                    @endif
                     <li class="{{Request::segment(1)=="listbooking"?'active':''}}">
                        <a href="{{url('listbooking')}}">
                            <i class="ti-view-list-alt"></i>
                            <p style="font-size:16px;">รายการจองรถ</p>
                        </a>
                    </li>
                    <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="member"))?'active':''}}">
                        <a href="{{url('manage/member')}}">
                            <i class="glyphicon glyphicon-user"></i>
                            @if(Session::get('level')>2)
                                <p style="font-size:16px;">จัดการข้อมูลสมาชิก</p>
                            @else
                                <p style="font-size:16px;">ข้อมูลสมาชิก</p>
                            @endif
                        </a>
                    </li>
                    <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="car"))?'active':''}}">
                        <a href="{{url('manage/car')}}">
                            <i class="ti-truck"></i>
                            @if(Session::get('level')>2)
                                <p style="font-size:16px;">จัดการข้อมูลรถ</p>
                            @else
                                <p style="font-size:16px;">ข้อมูลรถ</p>
                            @endif
                        </a>
                    </li>
                    @if(Session::get('level')!=2)
                       <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="usability"))?'active':''}}">
                        <a href="{{url('manage/usability')}}">
                            <i class="glyphicon glyphicon-dashboard"></i>
                            <p style="font-size:16px;">บันทึกการใช้รถ</p>
                        </a>
                    </li>
                          <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="pickup"))?'active':''}}">
                        <a href="{{url('manage/pickup')}}">
                            <i class="glyphicon glyphicon-oil"></i>
                            <p style="font-size:16px;">บันทึกการเบิกน้ำมัน</p>
                        </a>
                    </li>
                         <li class="{{((Request::segment(1)=="manage")&&(Request::segment(2)=="mainternance"))?'active':''}}">
                        <a href="{{url('manage/mainternance')}}">
                            <i class="glyphicon glyphicon-wrench"></i>
                            <p style="font-size:16px;">บันทึกการซ่อมบำรุงรถ</p>
                        </a>
                    </li>
                    @endif
                    @if(Session::get('level')>2)
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='booking') ?'active':''}}">
                        <a href="{{url('report/booking')}}">
                            <i class="ti-map"></i>
                            <p style="font-size:16px;">รายงานการจองรถ</p>
                        </a>
                    </li>
                    <li  class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='usability')?'active':''}}">
                        <a href="{{url('report/usability')}}">
                            <i class="glyphicon glyphicon-scale"></i>
                            <p style="font-size:16px;">รายงานการใช้งานรถ</p>
                        </a>
                    </li>
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='pickup')?'active':''}}">
                        <a href="{{url('report/pickup')}}">
                            <i class="ti-paint-bucket"></i>
                            <p style="font-size:16px;">รายงานการเบิกน้ำมัน</p>
                        </a>
                    </li>
                    <li class="{{(Request::segment(1)=='report')&&(Request::segment(2)=='mainternance')?'active':''}}">
                        <a href="{{url('report/mainternance')}}">
                            <i class="ti-settings"></i>
                            <p style="font-size:16px;">รายงานการซ่อมบำรุง</p>
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
                    <a class="navbar-brand" href="#" style="font-size:40px;">
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
     @section('costom-js') @show   
    <!-- Sweetalert -->
        <script src="{{URL::to('assets/sweetalert2/sweetalert2.min.js')}}"></script>
        <link rel="stylesheet" href="{{URL::to('assets/sweetalert2/sweetalert2.min.css')}}">
    <!-- Bootstrap -->
        <script src="{{URL::to('assets/bootstrap-3.3.7/js/bootstrap.min.js')}}"></script>         
    <!--     Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{URL::to('assets/js/paper-dashboard.js')}}"></script>
    <!--Login -->
    @if(!Auth::check())
      <script src="{{URL::to('assets/login/login.js')}}"></script>
    @endif
</html>