<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMicrosite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use BelongsToMicrosite;

    protected $fillable = [
        'microsite_id', 'order_code', 'customer_name', 'customer_phone',
        'table_number', 'notes', 'status', 'total_price',
    ];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
