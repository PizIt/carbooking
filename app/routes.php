<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('home');
});
Route::controller('home','HomeController');
Route::controller('login','LoginController');

Route::group(array('before'=>'auth'),function(){
        // Notification
    Route::controller('notification','NotificationController');
        //Booking
    Route::controller('booking','BookingController');
    Route::controller('listbooking','ListBookingController'); 

    Route::controller('member','MemberController');

      //Manage 
    Route::controller('manage/member','Manage_ManageMemberController');
    Route::controller('manage/car','Manage_ManageCarController');
    Route::controller('manage/usability','Manage_ManageUsabilityCarController');
    Route::controller('manage/pickup','Manage_ManagePickupController');
    Route::controller('manage/mainternance','Manage_ManageMainternanceController');

    //Report 
    Route::controller('report/booking','Report_ReportBookingController');
    Route::controller('report/usability','Report_ReportUsabilityCarController');
    Route::controller('report/pickup','Report_ReportPickFuelController');
    Route::controller('report/mainternance','Report_ReportMainternanceController');
});
