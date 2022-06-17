<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $with = ['author'];

    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')->orWhere('alamat', 'like', '%' . $search . '%');
            });
        });
    }

    public static function getCourierByCourierId($id)
    {
        return Courier::where('id', $id)->first();
    }

    public static function getCourierByCourierIdTracking($id)
    {
        return Courier::where('id', $id)->first();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->hasMany(Package::class);
    }
}
