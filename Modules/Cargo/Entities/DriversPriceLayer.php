<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriversPriceLayer extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'drivers_price_layers';
    

    public function driverPrice(){
        return $this->belongsTo(DriversPrice::class , 'drivers_price_id') ;
    }

    public function fromState(){
        return $this->belongsTo(State::class , 'from_state_id') ;
    }
    public function toState(){
        return $this->belongsTo(State::class , 'to_state_id') ;
    }

    public function fromArea(){
        return $this->belongsTo(Area::class , 'from_area_id') ;
    }

    public function toArea(){
        return $this->belongsTo(Area::class , 'to_area_id') ;
    }

}
