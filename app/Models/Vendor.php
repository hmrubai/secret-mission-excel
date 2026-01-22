<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'website',
        'company_name',
        'tax_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'is_active',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
