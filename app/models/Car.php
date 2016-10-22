<?php
//use Illuminate\Database\Eloquent\Collection;
class Car extends Eloquent {
    protected  $table ="cars";
    
    public function pickfuel()
    {
        return  $this->hasMany('PickFuel','pk_car_id');
        //hasMany ใส่ชื่อ Class
    }
    public function driver()
    {
        return $this->belongsTo('Member','car_driver_id');
    }
}
