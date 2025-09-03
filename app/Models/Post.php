<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Models\Category;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    use HasSlug;

    protected $table = 'posts';

    protected $fillable = [
        // 'image',
        'title',
        'slug',
        'content',
        'user_id',
        'category_id',
        'published_at'
    ];

    // Add proper date casting
    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }


    // Media Conversion | Queue Conversion: Image
    // [Commandline]
    // php artisan queue:listen
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400);

        $this
            ->addMediaConversion('original')
            ->width(1200);
    }

    public function getImageUrl($conversionName = '')
    {
        $media = $this->getFirstMedia();

        if ($this->image && !str_starts_with($this->image, 'http')) {
            return Storage::url($this->image);
        } else if ($media->hasGeneratedConversion($conversionName)) {
            return $media->getUrl($conversionName);
        } else {
            return $media->getUrl();
        }
    }


    // Relationship with the User model [Many to One]
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the Category model [Many to One]
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with the Like model [One to Many]
    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    // Read Time Public Method
    public function readTime($wordsPerMinute = 200): string
    {
        $wordCount = str_word_count($this->content);
        $minutes = ceil($wordCount / $wordsPerMinute);

        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    }

    public function hasLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
