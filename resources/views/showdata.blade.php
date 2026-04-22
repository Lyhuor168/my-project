<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; background:#f5f5f5; padding:2rem; }
        h1 { font-size:1.8rem; margin-bottom:1.5rem; color:#1a1a1a; }
        .search-wrap { display:flex; gap:0.75rem; margin-bottom:1.5rem; }
        .search-input { flex:1; padding:0.75rem 1rem; border:1.5px solid #e5e7eb; border-radius:8px; font-size:0.9rem; outline:none; transition:border-color 0.2s; }
        .search-input:focus { border-color:#3b82f6; }
        .search-btn { padding:0.75rem 1.5rem; background:#1a1a2e; color:#fff; border:none; border-radius:8px; font-size:0.9rem; cursor:pointer; transition:background 0.2s; }
        .search-btn:hover { background:#3b82f6; }
        .clear-btn { padding:0.75rem 1rem; background:#fee2e2; color:#dc2626; border:none; border-radius:8px; font-size:0.9rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; }
        table { width:100%; border-collapse:collapse; background:#1a1a2e; border-radius:10px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.15); }
        thead tr { background:#16213e; }
        th { padding:1rem 1.25rem; text-align:left; color:#94a3b8; font-size:0.85rem; text-transform:uppercase; }
        td { padding:0.875rem 1.25rem; color:#e2e8f0; font-size:0.9rem; border-bottom:1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:rgba(255,255,255,0.03); }
        .highlight { background:#fef08a; color:#1a1a1a; padding:1px 4px; border-radius:3px; }
        .no-result { text-align:center; padding:3rem; color:#9ca3af; }
        .pg-info { font-size:0.85rem; color:#6b7280; margin-top:1rem; }
        .pg { display:flex; align-items:center; gap:0.4rem; margin-top:0.75rem; flex-wrap:wrap; }
        .pg a, .pg span { display:inline-flex; align-items:center; justify-content:center; min-width:36px; height:36px; padding:0 0.75rem; border-radius:8px; font-size:0.875rem; text-decoration:none; border:1px solid #e5e7eb; color:#374151; background:#fff; }
        .pg a:hover { background:#f3f4f6; }
        .pg .active { background:#3b82f6; color:#fff; border-color:#3b82f6; font-weight:700; }
        .pg .disabled { color:#d1d5db; pointer-events:none; }
    </style>
</head>
<body>

<h1>Products</h1>

{{-- Search Form --}}
<form method="GET" action="{{ request()->url() }}" class="search-wrap">
    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="Search by ID or Name..."
        value="{{ request('search') }}"
        autofocus
    >
    <button type="submit" class="search-btn">🔍 Search</button>
    @if(request('search'))
        <a href="{{ request()->url() }}" class="clear-btn">✕ Clear</a>
    @endif
</form>

@if(request('search'))
<p style="font-size:0.85rem;color:#6b7280;margin-bottom:1rem">
    Results for: <strong style="color:#1a1a2e">"{{ request('search') }}"</strong>
    — {{ $pro->total() }} found
</p>
@endif

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>qty</th>
            <th>img</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pro as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>
                @if(request('search'))
                    {!! str_ireplace(
                        request('search'),
                        '<span class="highlight">'.request('search').'</span>',
                        $p->name
                    ) !!}
                @else
                    {{ $p->name }}
                @endif
            </td>
            <td>{{ number_format($p->price, 0) }}</td>
            <td>{{ $p->qty }}</td>
            <td>{{ $p->img }}</td>
            <td>{{ $p->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="no-result">
                😕 No products found for "{{ request('search') }}"
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@if(method_exists($pro, 'links'))
<div class="pg-info">
    Showing {{ $pro->firstItem() }} to {{ $pro->lastItem() }} of {{ $pro->total() }} results
</div>
<div class="pg">
    @if($pro->onFirstPage())
        <span class="disabled">« Previous</span>
    @else
        <a href="{{ $pro->previousPageUrl() . (request('search') ? '&search='.request('search') : '') }}">« Previous</a>
    @endif

    @for($i = 1; $i <= $pro->lastPage(); $i++)
        @if($i == $pro->currentPage())
            <span class="active">{{ $i }}</span>
        @else
            <a href="{{ $pro->url($i) . (request('search') ? '&search='.request('search') : '') }}">{{ $i }}</a>
        @endif
    @endfor

    @if($pro->hasMorePages())
        <a href="{{ $pro->nextPageUrl() . (request('search') ? '&search='.request('search') : '') }}">Next »</a>
    @else
        <span class="disabled">Next »</span>
    @endif
</div>
@endif

</body>
</html>
