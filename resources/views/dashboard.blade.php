@extends('layouts.app')
@section('title','Dashboard')
@section('heading','Dashboard')
@section('content')
<div class="welcome-row"><div><h2>Good day, {{ explode(' ', auth()->user()->name)[0] }}!</h2><p class="muted">Here's an overview of your archived documents.</p></div>@if(in_array(auth()->user()->role,['admin','personnel']))<a class="btn primary" href="{{ route('documents.create') }}">＋ Archive document</a>@endif</div>
<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon navy">▤</div><div><span>Total documents</span><strong>{{ number_format($counts['all']) }}</strong><small>All archived records</small></div></div>
    <div class="stat-card"><div class="stat-icon blue">✉</div><div><span>Letters</span><strong>{{ number_format($counts['letter']) }}</strong><small>LTR document series</small></div></div>
    <div class="stat-card"><div class="stat-icon green">▣</div><div><span>Clearance forms</span><strong>{{ number_format($counts['clearance']) }}</strong><small>CLR document series</small></div></div>
    <div class="stat-card"><div class="stat-icon orange">▧</div><div><span>Reports</span><strong>{{ number_format($counts['report']) }}</strong><small>RPT document series</small></div></div>
</div>
<div class="content-grid">
    <div class="panel"><div class="panel-heading"><div><h3>Recently archived</h3><p class="muted">Latest document records in the system</p></div><a class="text-link" href="{{ route('documents.index') }}">View all →</a></div>
    <div class="table-wrap"><table><thead><tr><th>Document number</th><th>Title</th><th>Type</th><th>Date</th></tr></thead><tbody>
    @forelse($recentDocuments as $doc)<tr><td><a class="table-link" href="{{ route('documents.show',$doc) }}">{{ $doc->document_number }}</a></td><td>{{ $doc->title }}</td><td><span class="type-pill {{ $doc->document_type }}">{{ $doc->type_label }}</span></td><td>{{ $doc->document_date->format('M d, Y') }}</td></tr>@empty<tr><td colspan="4" class="empty">No documents archived yet.</td></tr>@endforelse
    </tbody></table></div></div>
    <div class="panel"><div class="panel-heading"><div><h3>Archive activity</h3><p class="muted">Recent actions by system users</p></div></div>
    <div class="activity-list">@forelse($recentLogs as $log)<div class="activity-item"><span class="activity-dot"></span><div><strong>{{ $log->action }}</strong><p>{{ $log->document?->document_number ?? 'Document' }} · {{ $log->user?->name ?? 'User' }}</p><small>{{ $log->created_at->diffForHumans() }}</small></div></div>@empty<p class="empty">No activity recorded yet.</p>@endforelse</div></div>
</div>
@endsection
