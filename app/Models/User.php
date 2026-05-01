<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'locale',
        'avatar',
        'cover_image',
        'about_ar',
        'about_en',
        'profile_products_count',
        'gallery_images',
        'profile_video',
        'document_pdf',
        'certificates',
        'package_id',
        'stars',
        'passport',
        'country_id',
        'geographic_zone_id',
        'wallet_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'certificates' => 'array',
            'gallery_images' => 'array',
        ];
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? \Illuminate\Support\Facades\Storage::url($this->avatar) : asset('dist/img/user4-128x128.jpg');
    }

    /**
     * Get PDF URL
     */
    public function getPdfUrlAttribute()
    {
        return $this->document_pdf ? \Illuminate\Support\Facades\Storage::url($this->document_pdf) : null;
    }

    /**
     * Get certificates URLs
     */
    public function getCertificateUrlsAttribute()
    {
        if (!$this->certificates) return [];
        return array_map(fn($path) => \Illuminate\Support\Facades\Storage::url($path), $this->certificates);
    }

    /**
     * Get associated package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function verifications()
    {
        return $this->belongsToMany(Verification::class, 'user_verification');
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'user_sectors');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function geographicZone()
    {
        return $this->belongsTo(GeographicZone::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function news()
    {
        return $this->hasMany(UserNews::class);
    }

    /**
     * Get the panel type for routes and views
     */
    public function getPanelTypeAttribute(): string
    {
        return match($this->type) {
            'regional_office' => 'regional',
            'ngis'            => 'ngis',
            'merchant'        => 'client',
            'company_owner'   => 'client',
            'global_forwarding' => 'global_forwarding',
            default           => $this->type ?? 'user',
        };
    }
}
