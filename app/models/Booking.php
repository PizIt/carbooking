<?php
class Booking extends Eloquent {
    protected  $table ="booking";
    
    public function bookingCars()
    {
        return $this->hasMany('bookingcar','bc_book_id');
    }
    public function bookingDrivers()
    {
        return $this->hasMany('bookingdriver','bd_book_id');
    }
}
