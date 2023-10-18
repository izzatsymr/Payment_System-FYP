<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scanner extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'amount', 'mode', 'user_id'];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class)
            ->withPivot(['is_success']) // Include the additional attributes
            ->withTimestamps(); // Include the timestamps
    }

}