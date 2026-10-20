<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMicrosite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use BelongsToMicrosite;

    protected $fillable = [
        'order_id', 'microsite_id', 'menu_item_id',
        'item_name', 'unit_price', 'quantity',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }
}
