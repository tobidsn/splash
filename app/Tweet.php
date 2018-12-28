<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tweet extends Model
{
    protected $fillable = [
    	'user_id', 'body',
    ];

    public function getCreatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d h:i:s', $value)->diffForHumans();
    }

    public function author()
	{
	    return $this->belongsTo('App\User', 'user_id');
	}

	public function link()
    {
        return $this->belongsTo('App\Link', 'link_id');
    }
}
