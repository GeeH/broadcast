<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'date',
    ];

    public function getDateAttribute(string $value): int
    {
        return strtotime($value);
    }

}
