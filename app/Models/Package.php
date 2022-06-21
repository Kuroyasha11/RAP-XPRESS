<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Package extends Model
{
    use HasFactory, Sluggable;

    protected $with = ['author', 'shipping', 'courier', 'pickup'];

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('slug', $search);
            });
        });
    }

    public static function getPackageByCourierId($id)
    {
        return Package::where('courier_id', $id)->where('terima', 1)->where('selesai', 0)->get();
    }

    public static function getPackageByCourierIdindex($id)
    {
        return Package::where('courier_id', $id)->where('terima', 1)->get();
    }

    public static function getPackageByPickUpId($id)
    {
        return Package::where('pick_up_id', $id)->where('terima', 1)->where('selesai', 0)->get();
    }

    public static function getPackageByPickUpIdindex($id)
    {
        return Package::where('pick_up_id', $id)->where('terima', 1)->get();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function pickup()
    {
        return $this->belongsTo(PickUp::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }
}
