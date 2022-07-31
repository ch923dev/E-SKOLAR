<?php

namespace App\Filament\Trait;

trait Permits
{
    public static function can_view($module): bool
    {
        return auth()->user()->permissions->where('name', 'View '.ucfirst($module))->first() ? true : false;
    }
    public static function can_manage($module): bool
    {
        return auth()->user()->permissions->where('name', 'Manage '.ucfirst($module))->first() ? true : false;
    }
}
