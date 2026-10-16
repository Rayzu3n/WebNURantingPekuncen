<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'history',
        'vision',
        'mission',
        'structure',
        'programs',
        'address',
        'contact_email',
        'contact_phone',
        'website_url',
        'facebook_url',
        'instagram_url',
    ];
}
