<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    protected $fillable = [
        'title', 'level', 'description',
        'price', 'file_path', 'user_id', 'instructor_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function instructor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function students() {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }
}