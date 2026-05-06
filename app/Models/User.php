<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

#[ApiResource]
class User extends Model {
    use HasRoles;

    protected $fillable = [
        'login', 'email', 'password',
        'first_name', 'last_name', 'dob',
        'phone', 'bio', 'avatar'
    ];

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses() {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }

    public function getFullNameAttribute() {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->login;
    }
}