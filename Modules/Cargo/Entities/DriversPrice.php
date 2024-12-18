<?php

namespace Modules\Cargo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriversPrice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $table = 'drivers_prices';
    
    public function driverPriceLayers(){
        return $this->hasMany(DriversPriceLayer::class , 'drivers_price_id') ;
    }
 
}
