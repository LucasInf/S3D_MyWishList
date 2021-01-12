<?php

namespace mywishlist\models;

class Message extends \Illuminate\Database\Eloquent\Model {
    public $timestamps;
    protected $table = "message";
    protected $primaryKey = "id";

    public function liste() {
        return $this->belongsTo('\mywishlist\models\Liste', 'no');
    }


}