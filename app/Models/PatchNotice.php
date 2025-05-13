<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatchNotice extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'patch_notices';

    // Define which fields are mass assignable
    protected $fillable = [
        'title',
        'description',
        'notes',
    ];
}
