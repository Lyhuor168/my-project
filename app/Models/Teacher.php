<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        "name","email","phone","subject",
        "address","dob","gender","photo",
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
