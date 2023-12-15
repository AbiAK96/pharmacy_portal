<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;
    protected $table = 'quotation_items';

    protected $fillable = [
        'quotation_id',
        'drug',
        'unit_price',
        'quantity',
    ];
}
