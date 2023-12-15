<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';

    protected $fillable = [
        'user_id',
        'prescription_id',
        'total',
        'is_mailed',
        'note',
        'delivery_address',
        'delivery_date'
    ];
}
