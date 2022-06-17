<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    protected $with = ['partner'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = ['id'];

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
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('no_hp', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
            });
        });
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function courier()
    {
        return $this->hasOne(Courier::class);
    }
    public function PickUp()
    {
        return $this->hasOne(PickUp::class);
    }

    public function package()
    {
        return $this->hasMany(Package::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getUserByPackageID($id)
    {
        return User::where('id', $id)->first();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
