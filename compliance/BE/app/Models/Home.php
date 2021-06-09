<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function event(){
        return $this->belongsTo(Events::class, 'events_id', 'id');
    }

    public function gallery(){
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }

    public function rate(){
        return $this->belongsTo(Rates::class, 'rates_id', 'id');
    }
}
