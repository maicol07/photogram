<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rawilk\Settings\Models\HasSettings;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasSettings;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'username',
        'profileImage',
        'email_verified_at',
        'google_id',
        'google_token',
        'google_refresh_token',
        'spotify_id',
        'spotify_token',
        'spotify_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array'
    ];

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getSetting(string $key): mixed
    {
        return $this->settings[$key] ?? null;
    }

    public function setSetting(string $key, mixed $value): void
    {
        $this->settings[$key] = $value;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'followers',
            'user_follower',
            'user_follow'
        );
    }

    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(
            self::class,
            'followers',
            'user_follow',
            'user_follower'
        );
    }

    public function commentLikes(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comments_likes');
    }

    public function postsLikes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'posts_likes');
    }

    public function isLinkedToGoogle(): bool
    {
        return $this->google_id !== null;
    }
}
