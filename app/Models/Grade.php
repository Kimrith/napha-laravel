<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'course_name',
        'mid_score',
        'final_score',
        'grade',
        'gpa',
        'standing',
        'certified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mid_score' => 'decimal:2',
        'final_score' => 'decimal:2',
        'gpa' => 'decimal:2',
        'certified_at' => 'datetime',
    ];

    /**
     * Get the student associated with this grade.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course associated with this grade.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
