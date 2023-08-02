<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_number",
        "product",
        "section_id",
        "status",
        "value_status",
        "note",
        "user",
        "invoice_id",
        "payment_date"
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
