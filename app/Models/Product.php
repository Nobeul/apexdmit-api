<?php

namespace App\Models;

use App\Traits\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use Scope;

    protected $fillable = ['name', 'price', 'stock'];

    const CACHE_KEY = 'products';

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function findByFilters(array $data, array $relations = [], $paginate = true, $limit = 10, $first = false)
    {
        if (! $paginate) {
            if ($cachedData = Cache::get(self::CACHE_KEY)) {
                return $cachedData;
            }
        }

        $query = self::query();

        $query->when(count($relations) > 0, function ($q) use ($relations) {
            $q->with($relations);
        })
        ->when(!empty($data['id']), function ($q) use ($data) {
            $q->where('id', $data['id']);
        })
        ->when(!empty($data['name']), function ($q) use ($data) {
            $q->whereLike('name', $data['name']);
        })
        ->when(!empty($data['price']), function ($q) use ($data) {
            $q->where('price', $data['price']);
        })
        ->when(!empty($data['stock']), function ($q) use ($data) {
            $q->where('stock', $data['stock']);
        });

        if ($first) {
            $filtered_data = $query->first();
        } elseif ($paginate) {
            $filtered_data = $query->paginate($limit);
        } else {
            $filtered_data = $query->get();
            Cache::put(self::CACHE_KEY, $filtered_data, 60 * 10);
        }


        return $filtered_data;
    }
}
