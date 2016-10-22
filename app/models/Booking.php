<?php
class Booking extends Eloquent {
    protected  $table ="booking";
    
    public function bookingCars()
    {
        return $this->hasMany('BookingCar','bc_book_id');
    }
    public function bookingDrivers()
    {
        return $this->hasMany('BookingDriver','bd_book_id');
    }
}
