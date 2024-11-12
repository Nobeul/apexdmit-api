<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\Role;

class RoleHelper
{
    public static function getRoleByName(string $name)
    {
        return Cache::remember("role_{$name}", 3600, function () use ($name) {
            return Role::where('name', $name)->first();
        });
    }
}
