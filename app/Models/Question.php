<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question', 'description',
    ];

    public function forms() {
        return $this->belongsToMany(Form::class);
    }
}
