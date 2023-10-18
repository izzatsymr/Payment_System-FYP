<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'rfid',
        'security_key',
        'balance',
        'status',
        'student_id',
    ];

    protected $searchableFields = ['*'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scanners()
    {
        return $this->belongsToMany(Scanner::class);
    }
}
