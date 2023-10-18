<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'address',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function card()
    {
        return $this->hasOne(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
