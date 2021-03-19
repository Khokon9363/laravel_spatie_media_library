<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->acceptsFile(function (File $file) {
            return $file->mimeType === 'image/jpeg';
        })
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('card')
                    ->width(400)
                    ->height(300);

                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }

    public function avatar()
    {
        return $this->hasOne(Media::class, 'id', 'avatar_id');
    }

    // It will be for avatarUrl with realationship avatar above of this function
    public function getAvatarUrlAttribute()
    {
        if (count(Media::all()) === 0) {
            return;
        }
        return $this->avatar->getUrl('thumb');
    }
}
