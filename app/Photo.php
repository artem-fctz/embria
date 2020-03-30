<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Photo
 *
 * @package App
 */
class Photo extends Model  implements HasMedia
{
    use HasMediaTrait;

    protected $table='tbl_photos';

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likable');
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('payload')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }


    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($photo) { // before delete() method call this
            $photo->likes()->delete();
            // do the rest of the cleanup...
        });
    }
}
