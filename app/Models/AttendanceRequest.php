<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AttendanceRequest extends Model
{
    protected $fillable = ["student_id","class_id","date","reason","status","reviewed_by","note","reviewed_at"];
    protected $casts = ["date" => "date", "reviewed_at" => "datetime"];
    public function student() { return $this->belongsTo(Student::class); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class, "class_id"); }
    public function reviewer() { return $this->belongsTo(User::class, "reviewed_by"); }
    public function isPending() { return $this->status === "pending"; }
    public function isApproved() { return $this->status === "approved"; }
    public function isRejected() { return $this->status === "rejected"; }
}