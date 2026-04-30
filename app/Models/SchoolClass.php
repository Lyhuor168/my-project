<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'school_classes';
    protected $fillable = ['name', 'code', 'description', 'max_students'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
