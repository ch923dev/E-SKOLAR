<?php

namespace App\Filament\Trait;

trait Permits
{
    public static function can_view($relationship): bool
    {
        return auth()->user()->permissions->where('name', 'View '.ucfirst($relationship))->first() ? true : false;
    }
    public static function can_manage($relationship): bool
    {
        return auth()->user()->permissions->where('name', 'Manage '.ucfirst($relationship))->first() ? true : false;
    }
}
