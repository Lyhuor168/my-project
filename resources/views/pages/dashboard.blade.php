@extends('layouts.master')
@section('title', 'Admin Dashboard')
@section('styles')
<style>
.dash-wrap{background:#f0f4f8;min-height:100vh;padding:24px}
.dash-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px}
.dash-greeting h3{font-size:1.5rem;font-weight:800;color:#1e293b;margin:0}
.dash-greeting p{color:#64748b;margin:0;font-size:.9rem}
.dash-date{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:8px 16px;font-size:.85rem;font-weight:600;color:#475569}
.stat-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
@media(max-width:900px){.stat-cards{grid-template-columns:repeat(2,1fr)}}
@media(max-width:500px){.stat-cards{grid-template-columns:1fr}}
.stat-card{background:#fff;border-radius:16px;padding:20px;display:flex;align-items:center;gap:16px;box-shadow:0 1px 8px rgba(0,0,0,.06)}
.stat-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0}
.stat-num{font-size:2rem;font-weight:800;line-height:1;margin-bottom:2px}
.stat-lbl{font-size:.75rem;color:#64748b;font-weight:600;text-transform:uppercase}
.stat-sub{font-size:.75rem;font-weight:600;margin-top:4px}
.charts-row{display:grid;grid-template-columns:1fr 340px;gap:16px;margin-bottom:24px}
@media(max-width:1024px){.charts-row{grid-template-columns:1fr}}
.chart-card{background:#fff;border-radius:16px;padding:20px;box-shadow:0 1px 8px rgba(0,0,0,.06)}
.chart-title{font-size:.95rem;font-weight:700;color:#1e293b;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center}
.bottom-row{display:grid;grid-template-columns:1fr 1fr 340px;gap:16px;margin-bottom:24px}
@media(max-width:1100px){.bottom-row{grid-template-columns:1fr 1fr}}
@media(max-width:700px){.bottom-row{grid-template-columns:1fr}}
.class-item{display:flex;align-items:center;gap:10px;margin-bottom:12px}
.class-name{font-size:.82rem;font-weight:600;color:#475569;width:90px;flex-shrink:0}
.class-bar{flex:1;height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden}
.class-fill{height:100%;border-radius:4px;transition:width .5s}
.class-rate{font-size:.82rem;font-weight:700;width:40px;text-align:right;flex-shrink:0}
.att-table{width:100%;font-size:.82rem}
.att-table th{font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;padding:6px 8px;border-bottom:1px solid #f1f5f9}
.att-table td{padding:10px 8px;border-bottom:1px solid #f8fafc;vertical-align:middle}
.att-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700}
.alert-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #f1f5f9}
.alert-item:last-child{border-bottom:none}
.alert-dot{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0}
.alert-msg{font-size:.82rem;font-weight:600;color:#1e293b}
.alert-sub{font-size:.75rem;color:#94a3b8;margin-top:2px}
.alert-time{font-size:.72rem;color:#94a3b8;margin-left:auto;flex-shrink:0;white-space:nowrap}
.quick-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
@media(max-width:700px){.quick-actions{grid-template-columns:repeat(2,1fr)}}
.quick-btn{background:#fff;border-radius:14px;padding:18px 16px;text-align:center;text-decoration:none;color:#1e293b;box-shadow:0 1px 8px rgba(0,0,0,.06);transition:all .2s;border:1px solid #f1f5f9}
.quick-btn:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.1);color:#1a237e}
.quick-btn i{font-size:1.5rem;margin-bottom:8px;display:block}
.quick-btn span{font-size:.8rem;font-weight:700}
[data-theme='dark'] .dash-wrap{background:#0f172a}
[data-theme='dark'] .stat-card,[data-theme='dark'] .chart-card,[data-theme='dark'] .quick-btn{background:#1e293b;color:#e2e8f0}
</style>
@endsection

@section('content')
<div class="dash-wrap">
<div class="dash-header">
    <div class="dash-greeting">
        <h3>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ $stats['user_name'] }}!</h3>
        <p>{{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="dash-date"><i class="fas fa-calendar-alt me-2"></i>{{ now()->format('d/m/Y') }}</div>
</div>

<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-icon" style="background:#dbeafe;"><i class="fas fa-user-check" style="color:#2563eb;"></i></div>
        <div>
            <div class="stat-num" style="color:#2563eb;">{{ $presentToday }}</div>
            <div class="stat-lbl">Present Today</div>
            <div class="stat-sub" style="color:#16a34a;">{{ $totalToday>0?round($presentToday/$totalToday*100):0 }}% of total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fee2e2;"><i class="fas fa-user-times" style="color:#dc2626;"></i></div>
        <div>
            <div class="stat-num" style="color:#dc2626;">{{ $absentToday }}</div>
            <div class="stat-lbl">Absent Today</div>
            <div class="stat-sub" style="color:#dc2626;">{{ $totalToday>0?round($absentToday/$totalToday*100):0 }}% of total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;"><i class="fas fa-clock" style="color:#d97706;"></i></div>
        <div>
            <div class="stat-num" style="color:#d97706;">{{ $lateToday }}</div>
            <div class="stat-lbl">Late Today</div>
            <div class="stat-sub" style="color:#d97706;">{{ $totalToday>0?round($lateToday/$totalToday*100):0 }}% of total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f3e8ff;"><i class="fas fa-chart-line" style="color:#9333ea;"></i></div>
        <div>
            <div class="stat-num" style="color:#9333ea;">{{ $attendanceRate }}%</div>
            <div class="stat-lbl">Attendance Rate</div>
            <div class="stat-sub" style="color:#16a34a;"><i class="fas fa-arrow-up me-1"></i>vs yesterday</div>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="chart-card">
        <div class="chart-title">
            <span>Attendance Trend <small class="text-muted fw-normal">(This Week)</small></span>
            <span class="badge bg-light text-dark border">This Week</span>
        </div>
        <canvas id="trendChart" height="100"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">Attendance Overview</div>
        <canvas id="donutChart" height="160"></canvas>
        <div class="mt-3">
            @foreach([['Present','#16a34a',$presentToday],['Absent','#dc2626',$absentToday],['Late','#d97706',$lateToday],['Leave','#94a3b8',0]] as [$lbl,$clr,$val])
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:10px;height:10px;border-radius:50%;background:{{ $clr }};"></div>
                    <span style="font-size:.82rem;color:#64748b;">{{ $lbl }}</span>
                </div>
                <span style="font-size:.82rem;font-weight:700;">{{ $totalToday>0&&$val>0?round($val/$totalToday*100):0 }}% ({{ $val }})</span>
            </div>
            @endforeach
            <div class="text-center mt-2" style="font-size:.8rem;color:#94a3b8;">Total {{ $totalToday }}</div>
        </div>
    </div>
</div>

<div class="bottom-row">
    <div class="chart-card">
        <div class="chart-title">
            Attendance by Class
            <a href="{{ route('attendances.index') }}" style="font-size:.78rem;color:#2563eb;text-decoration:none;">View All</a>
        </div>
        @forelse($classSummary as $cs)
        <div class="class-item">
            <div class="class-name">{{ $cs['name'] }}</div>
            <div class="class-bar">
                <div class="class-fill" style="width:{{ $cs['rate'] }}%;background:{{ $cs['rate']>=80?'#16a34a':($cs['rate']>=65?'#d97706':'#dc2626') }};"></div>
            </div>
            <div class="class-rate" style="color:{{ $cs['rate']>=80?'#16a34a':($cs['rate']>=65?'#d97706':'#dc2626') }};">{{ $cs['rate'] }}%</div>
        </div>
        @empty
        <p class="text-muted small text-center py-3">មិនមានថ្នាក់</p>
        @endforelse
    </div>

    <div class="chart-card">
        <div class="chart-title">
            Recent Attendance
            <a href="{{ route('attendances.index') }}" style="font-size:.78rem;color:#2563eb;text-decoration:none;">View All</a>
        </div>
        <table class="att-table">
            <thead><tr><th>Student</th><th>Class</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($recentAttendance as $att)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="att-avatar">{{ mb_substr($att->student->name??'S',0,1,'UTF-8') }}</div>
                            <span>{{ Str::limit($att->student->name??'-',12) }}</span>
                        </div>
                    </td>
                    <td>{{ $att->schoolClass->name??'-' }}</td>
                    <td>
                        @if($att->status=='present') <span class="badge" style="background:#dcfce7;color:#16a34a;">Present</span>
                        @elseif($att->status=='absent') <span class="badge" style="background:#fee2e2;color:#dc2626;">Absent</span>
                        @else <span class="badge" style="background:#fef3c7;color:#d97706;">Late</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-3 text-muted">No attendance today</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="chart-card">
        <div class="chart-title">Alerts & Notifications</div>
        @forelse($alerts as $alert)
        <div class="alert-item">
            <div class="alert-dot" style="background:{{ $alert['type']=='danger'?'#fee2e2':($alert['type']=='warning'?'#fef3c7':'#dbeafe') }};">
                <i class="{{ $alert['icon'] }}" style="color:{{ $alert['type']=='danger'?'#dc2626':($alert['type']=='warning'?'#d97706':'#2563eb') }};"></i>
            </div>
            <div>
                <div class="alert-msg">{{ $alert['msg'] }}</div>
                <div class="alert-sub">{{ $alert['sub'] }}</div>
            </div>
            <div class="alert-time">{{ $alert['time'] }}</div>
        </div>
        @empty
        <div class="text-center py-3 text-muted small"><i class="fas fa-check-circle text-success me-1"></i>No alerts</div>
        @endforelse
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('attendances.create') }}" class="quick-btn">
        <i class="fas fa-clipboard-check" style="color:#2563eb;"></i><span>Take Attendance</span>
    </a>
    <a href="{{ route('attendances.report') }}" class="quick-btn">
        <i class="fas fa-chart-bar" style="color:#16a34a;"></i><span>Attendance Report</span>
    </a>
    <a href="{{ route('students.index') }}" class="quick-btn">
        <i class="fas fa-user-graduate" style="color:#9333ea;"></i><span>Students</span>
    </a>
    <a href="{{ route('students.index') }}" class="quick-btn">
        <i class="fas fa-bell" style="color:#d97706;"></i><span>Send Notification</span>
    </a>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($weekTrend, 'day')) !!},
        datasets:[{
            label:'Attendance Rate %',
            data:{!! json_encode(array_column($weekTrend, 'rate')) !!},
            borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,0.08)',
            borderWidth:2.5,pointBackgroundColor:'#2563eb',pointRadius:5,tension:0.4,fill:true
        }]
    },
    options:{
        responsive:true,plugins:{legend:{display:false}},
        scales:{y:{min:0,max:100,ticks:{callback:v=>v+'%'},grid:{color:'#f1f5f9'}},x:{grid:{display:false}}}
    }
});

const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type:'doughnut',
    data:{
        labels:['Present','Absent','Late'],
        datasets:[{data:[{{ $presentToday }},{{ $absentToday }},{{ $lateToday }}],backgroundColor:['#16a34a','#dc2626','#d97706'],borderWidth:0,hoverOffset:6}]
    },
    options:{
        cutout:'70%',responsive:true,
        plugins:{legend:{display:false}}
    },
    plugins:[{id:'center',beforeDraw(chart){
        const{width,height,ctx}=chart;
        ctx.save();
        ctx.font='bold 14px sans-serif';ctx.fillStyle='#64748b';ctx.textAlign='center';ctx.textBaseline='middle';
        ctx.fillText('Total',width/2,height/2-12);
        ctx.font='bold 26px sans-serif';ctx.fillStyle='#1e293b';
        ctx.fillText({{ $totalToday }},width/2,height/2+12);
        ctx.restore();
    }}]
});
</script>
@endsection
