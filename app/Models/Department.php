<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'head',
        'budget',
        'students_count',
        'faculty_count',
        'programs_count',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'students_count' => 'integer',
        'faculty_count' => 'integer',
        'programs_count' => 'integer',
    ];

    /**
     * Get students enrolled in this department.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get courses offered by this department.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Retrieve the model for a bound value (supports both primary id and code).
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        if ($field) {
            return $this->where($field, $value)->first();
        }

        return $this->where('id', $value)
            ->orWhere('code', $value)
            ->first();
    }
}
