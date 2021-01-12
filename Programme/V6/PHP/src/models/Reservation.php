<?php

namespace mywishlist\model;

use \Illuminate\Database\Eloquent\Model;

class Reservation
    extends Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'idReservation';
    public $timestamps = false;
    public $incrementing = false;

    public function item() {return $this->belongsTo('mywishlist\model\Items','idItem','id');}
}