<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassM extends Model
{
    protected $table = 'classes';

    public function students(){
        return $this->HasMany(Student::class, 'class_id');
    }
}
