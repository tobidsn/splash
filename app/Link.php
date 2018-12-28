<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\LinkCreated;


class Link extends Model
{
    protected $fillable = ['url', 'cover', 'title', 'description'];

    public function tweet()
    {
    	return $this->hasMany('App\Tweet', 'link_id');
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => LinkCreated::class
    ];
}
