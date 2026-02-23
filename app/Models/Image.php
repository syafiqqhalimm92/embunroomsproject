<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'imageable_type','imageable_id','path','disk','sort_order','mime','size'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    // helper to get url
    public function url()
    {
        return $this->disk === 'public' ? asset('storage/'.$this->path) : $this->path;
    }
}