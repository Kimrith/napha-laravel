<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'gender',
        'pronouns',
        'dob',
        'age',
        'email',
        'phone',
        'department_id',
        'class_id',
        'major',
        'degree',
        'gpa',
        'credits',
        'advisor',
        'status',
        'avatar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gpa' => 'decimal:2',
        'credits' => 'integer',
        'age' => 'integer',
    ];

    /**
     * Get the department associated with this student.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the class assigned to this student.
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get all enrolled classes for this student via pivot.
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_student', 'student_id', 'class_id')->withTimestamps();
    }

    /**
     * Get the attendances for this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the grades for this student.
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Retrieve the model for a bound value (supports both primary id and student_id code).
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        if ($field) {
            return $this->where($field, $value)->first();
        }

        return $this->where('id', $value)
            ->orWhere('student_id', $value)
            ->first();
    }
}
