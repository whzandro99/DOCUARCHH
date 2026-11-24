@extends('layouts.app')
@section('title',$document->document_number)
@section('heading','Document details')
@section('content')
<div class="page-toolbar"><div><a class="back-link" href="{{ route('documents.index') }}">← Back to archive</a><h2>{{ $document->title }}</h2><p class="muted">{{ $document->document_number }}</p></div>@if(in_array(auth()->user()->role,['admin','personnel']))<a class="btn primary" href="{{ route('documents.edit',$document) }}">Edit record</a>@endif</div>
<div class="detail-grid"><div class="panel detail-panel"><div class="detail-top"><span class="type-pill {{ $document->document_type }}">{{ $document->type_label }}</span><strong>{{ $document->document_number }}</strong></div>
<dl class="details"><div><dt>Document title</dt><dd>{{ $document->title }}</dd></div><div><dt>Sender</dt><dd>{{ $document->sender }}</dd></div><div><dt>Recipient</dt><dd>{{ $document->recipient ?: '—' }}</dd></div><div><dt>Document date</dt><dd>{{ $document->document_date->format('F d, Y') }}</dd></div><div><dt>Responsible office</dt><dd>{{ $document->office }}</dd></div><div><dt>Archived by</dt><dd>{{ $document->creator?->name ?? '—' }}</dd></div><div class="wide"><dt>Description / notes</dt><dd>{{ $document->description ?: 'No additional notes.' }}</dd></div></dl>
@if($document->file_path)<div class="attachment"><span>📎 Digital attachment</span><a class="btn light" target="_blank" href="{{ asset('storage/'.$document->file_path) }}">Open file ↗</a></div>@endif
@if(auth()->user()->role==='admin')<form method="POST" action="{{ route('documents.destroy',$document) }}" onsubmit="return confirm('Delete this document record? Its archive logs will also be removed.')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete record</button></form>@endif
</div>
<div class="panel"><div class="panel-heading"><div><h3>Archive history</h3><p class="muted">Recorded actions for this document</p></div></div><div class="activity-list">@forelse($document->logs as $log)<div class="activity-item"><span class="activity-dot"></span><div><strong>{{ $log->action }}</strong><p>{{ $log->user?->name ?? 'User' }} · {{ $log->details }}</p><small>{{ $log->created_at->format('M d, Y h:i A') }}</small></div></div>@empty<p class="empty">No history available.</p>@endforelse</div></div></div>
@endsection
