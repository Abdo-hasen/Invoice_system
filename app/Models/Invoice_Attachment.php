<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice_Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_id",
        "file_name",
        "invoice_number",
        "created_by",
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
