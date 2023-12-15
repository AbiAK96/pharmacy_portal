<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $table = 'prescriptions';

    protected $fillable = [
        'user_id',
        'image',
        'image1',
        'image2',
        'image3',
        'image4',
        'note',
        'delivery_address',
        'delivery_date',
        'is_executed',
    ];
}
