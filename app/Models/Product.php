<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable =
    [
        "name",
        "description",
        "section_id"
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public static function rules()
    {
        return [
            "description" => "required|string|min:3|max:225|regex:/^[a-zA-Z0-9\s]+$/",
            "section_id" => "required|exists:sections,id",
        ];
    }

    
}
