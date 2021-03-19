## Laravel Spatie Media Library

1. User.php
    To implement the package to our User model use -
        use Spatie\MediaLibrary\HasMedia;
        use Spatie\MediaLibrary\InteractsWithMedia;

    To defining an collection write on User.php -
        use Spatie\MediaLibrary\MediaCollections\File;
        public function registerMediaCollections(): void
        {
            ** Just For Image Upload and file acceptions **
            $this->addMediaCollection('avatar')->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg';
            });

            ** It's for conversions also **
            $this->addMediaCollection('avatar')->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg';
            })
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('card')
                    ->width(368)
                    ->height(232);
                    
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
        }

    **Those are for relationship on user avatar**
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
    
2. Handler.php
   To defining the appected files write on Handler.php

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof FileUnacceptableForCollection) {
            return redirect()->back()->with('error', 'Only JPEG file are acceptable');
        }
        return parent::render($request, $exception);
    }
    
3. Web.php
4. AvatarController.php