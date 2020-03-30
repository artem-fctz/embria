<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 *
 * @package App
 */
class Article extends Model
{
    protected $table='tbl_news';

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likable');
    }
}
