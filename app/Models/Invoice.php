<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Invoice_Attachment;
use App\Models\Invoice_Detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PATH = "files/invoices/";

    protected $fillable = [
        "invoice_number",
        "invoice_date",
        "due_date",
        "product",
        "section_id",
        "discount",
        "rate_vat",
        "value_vat",
        "status",//default
        "value_status",//default
        "amount_collection",
        "amount_commission",
        "total",
        "note",
        "payment_date", //nullable
        "file"
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function details()
    {
        return $this->hasMany(Invoice_Detail::class);
    }

    public function attachments()
    {
        return $this->hasMany(Invoice_Attachment::class);
    }


}
