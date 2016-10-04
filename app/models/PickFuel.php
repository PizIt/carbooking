<?php
class PickFuel extends Eloquent {
    protected  $table ="pick_fuel";
    
    public function car()
 	{
 		return $this->belongsTo('car','id');
 	}
}



