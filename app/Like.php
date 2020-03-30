<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * @package App
 */
class Like extends Model
{
    protected $table='tbl_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'likable_id', 'likable_type',
    ];

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get the owning likable model.
     */
    public function likable()
    {
        return $this->morphTo();
    }
}
