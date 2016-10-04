<?php
//use Illuminate\Database\Eloquent\Collection;
class Car extends Eloquent {
    protected  $table ="cars";
    
    public function pickfuel()
    {
        return  $this->hasMany('pickfuel','pk_car_id');
        //hasMany ใส่ชื่อ Class
    }
    public function driver()
    {
        return $this->belongsTo('member','car_driver_id');
    }
}
