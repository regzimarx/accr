<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "file_name",
        "designation_id",
    ];

    public function designation()
    {
        return $this->belongsTo(\App\Models\Designation::class);
    }
}
