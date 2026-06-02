@extends('layouts.master')
@section('title', 'មុខវិជ្ជា - ' . $course->name)
@section('content')

<style>
.cs-wrap { max-width: 1000px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

.cs-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
.cs-header-left { display: flex; align-items: center; gap: 14px; }
.cs-icon { width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 6px 18px rgba(0,0,0,0.15); flex-shrink: 0; }
.cs-title { font-size: 1.4rem; font-weight: 700; color: #1a237e; margin: 0; }
.cs-sub { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
.cs-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #9ca3af; margin-bottom: 4px; }
.cs-breadcrumb a { color: #3949ab; text-decoration: none; }

.cs-btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 10px; padding: 9px 18px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; }
.cs-btn-primary { background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; box-shadow: 0 4px 14px rgba(26,35,126,0.25); }
.cs-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }
.cs-btn-outline { background: #fff; color: #374151; border: 1.5px solid rgba(26,35,126,0.15); }
.cs-btn-outline:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }
.cs-btn-danger { background: #fff; color: #dc2626; border: 1.5px solid rgba(220,38,38,0.2); }
.cs-btn-danger:hover { background: #fef2f2; }

.cs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media (max-width: 700px) { .cs-grid { grid-template-columns: 1fr; } }

.cs-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); overflow: hidden; margin-bottom: 1.25rem; }
.cs-card-head { padding: 1rem 1.5rem; background: #fafbff; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 8px; }
.cs-card-head h5 { font-size: 0.9rem; font-weight: 700; color: #1a237e; margin: 0; }
.cs-card-body { padding: 1.5rem; }

.cs-info-row { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(26,35,126,0.05); }
.cs-info-row:last-child { border-bottom: none; }
.cs-info-icon { width: 32px; height: 32px; border-radius: 8px; background: #e8eaf6; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
.cs-info-label { font-size: 0.72rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
.cs-info-value { font-size: 0.875rem; color: #111827; font-weight: 500; }

.cs-chip { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #e8eaf6; color: #1a237e; margin: 2px; }
.cs-desc { font-size: 0.875rem; color: #374151; line-height: 1.7; }

.cs-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
.cs-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
</style>

@php $days = $course->days ? explode(',', $course->days) : []; @endphp

<div class="cs-wrap">

    @if(session('success'))
        <div class="cs-alert cs-alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="cs-header">
        <div class="cs-header-left">
            <div class="cs-icon" style="background:{{ $course->color ?? '#1a237e' }};">
                {{ $course->icon ?? '💻' }}
            </div>
            <div>
                <div class="cs-breadcrumb">
                    <a href="/">Home</a> /
                    <a href="{{ route('courses.index') }}">Courses</a> /
                    <span>{{ $course->name }}</span>
                </div>
                <h1 class="cs-title">{{ $course->name }}</h1>
                <div class="cs-sub">{{ $course->code }} · {{ $course->category }}</div>
            </div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('courses.edit', $course->id) }}" class="cs-btn cs-btn-primary">✏️ កែប្រែ</a>
            <a href="{{ route('courses.index') }}" class="cs-btn cs-btn-outline">← ត្រឡប់</a>
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('លុប {{ $course->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="cs-btn cs-btn-danger">🗑️ លុប</button>
            </form>
        </div>
    </div>

    <div class="cs-grid">
        {{-- Basic info --}}
        <div class="cs-card">
            <div class="cs-card-head"><h5>📋 ព័ត៌មានមូលដ្ឋាន</h5></div>
            <div class="cs-card-body">
                <div class="cs-info-row">
                    <div class="cs-info-icon">📚</div>
                    <div><div class="cs-info-label">ឈ្មោះ</div><div class="cs-info-value">{{ $course->name }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">#</div>
                    <div><div class="cs-info-label">លេខកូដ</div><div class="cs-info-value">{{ $course->code }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">🏷️</div>
                    <div><div class="cs-info-label">ប្រភេទ</div><div class="cs-info-value">{{ $course->category ?? '—' }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">👨‍🏫</div>
                    <div><div class="cs-info-label">គ្រូបង្រៀន</div><div class="cs-info-value">{{ $course->teacher ?? '—' }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">🎯</div>
                    <div><div class="cs-info-label">កម្រិត</div><div class="cs-info-value">{{ $course->level ?? '—' }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">👥</div>
                    <div><div class="cs-info-label">Max Students</div><div class="cs-info-value">{{ $course->max_students ?? '—' }}</div></div>
                </div>
            </div>
        </div>

        {{-- Schedule --}}
        <div class="cs-card">
            <div class="cs-card-head"><h5>🗓️ កាលវិភាគ</h5></div>
            <div class="cs-card-body">
                <div class="cs-info-row">
                    <div class="cs-info-icon">📅</div>
                    <div>
                        <div class="cs-info-label">ថ្ងៃចាប់ផ្ដើម</div>
                        <div class="cs-info-value">{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d M Y') : '—' }}</div>
                    </div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">📅</div>
                    <div>
                        <div class="cs-info-label">ថ្ងៃបញ្ចប់</div>
                        <div class="cs-info-value">{{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('d M Y') : '—' }}</div>
                    </div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">⏰</div>
                    <div>
                        <div class="cs-info-label">ម៉ោង</div>
                        <div class="cs-info-value">{{ $course->time_start ?? '--' }} – {{ $course->time_end ?? '--' }}</div>
                    </div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">⏱️</div>
                    <div><div class="cs-info-label">រយៈពេល</div><div class="cs-info-value">{{ $course->duration ? $course->duration . ' ម៉ោង' : '—' }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">🚪</div>
                    <div><div class="cs-info-label">បន្ទប់រៀន</div><div class="cs-info-value">{{ $course->room ?? '—' }}</div></div>
                </div>
                <div class="cs-info-row">
                    <div class="cs-info-icon">📆</div>
                    <div>
                        <div class="cs-info-label">ថ្ងៃរៀន</div>
                        <div class="cs-info-value">
                            @forelse($days as $d)
                                <span class="cs-chip">{{ $d }}</span>
                            @empty
                                —
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($course->description)
    <div class="cs-card">
        <div class="cs-card-head"><h5>📝 ការពិពណ៌នា</h5></div>
        <div class="cs-card-body">
            <p class="cs-desc">{{ $course->description }}</p>
        </div>
    </div>
    @endif

    {{-- Meta --}}
    <div style="font-size:0.75rem;color:#9ca3af;text-align:right;margin-top:0.5rem;">
        បានបង្កើត: {{ \Carbon\Carbon::parse($course->created_at)->format('d M Y') }} ·
        កែចុងក្រោយ: {{ \Carbon\Carbon::parse($course->updated_at)->format('d M Y') }}
    </div>

</div>
@endsection