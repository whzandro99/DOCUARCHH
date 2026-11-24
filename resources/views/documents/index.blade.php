@extends('layouts.app')
@section('title','Documents')
@section('heading','Document Archive')
@section('content')
<div class="page-toolbar"><div><h2>Archived documents</h2><p class="muted">Search and retrieve Letters, Clearance Forms, and Reports.</p></div>@if(in_array(auth()->user()->role,['admin','personnel']))<a class="btn primary" href="{{ route('documents.create') }}">＋ New document</a>@endif</div>
<form class="filter-bar" method="GET"><input type="search" name="q" value="{{ request('q') }}" placeholder="Search number, title, sender or recipient…">
<select name="type"><option value="">All document types</option><option value="letter" @selected(request('type')==='letter')>Letters</option><option value="clearance" @selected(request('type')==='clearance')>Clearance Forms</option><option value="report" @selected(request('type')==='report')>Reports</option></select>
<input type="date" name="date" value="{{ request('date') }}"><button class="btn dark" type="submit">Search</button><a class="btn light" href="{{ route('documents.index') }}">Reset</a></form>
<div class="panel"><div class="table-wrap"><table><thead><tr><th>Document number</th><th>Title</th><th>Type</th><th>Sender</th><th>Document date</th><th>Office</th><th></th></tr></thead><tbody>
@forelse($documents as $doc)<tr><td><a class="table-link" href="{{ route('documents.show',$doc) }}">{{ $doc->document_number }}</a></td><td>{{ $doc->title }}</td><td><span class="type-pill {{ $doc->document_type }}">{{ $doc->type_label }}</span></td><td>{{ $doc->sender }}</td><td>{{ $doc->document_date->format('M d, Y') }}</td><td>{{ $doc->office }}</td><td><a class="icon-link" href="{{ route('documents.show',$doc) }}">View →</a></td></tr>@empty<tr><td colspan="7" class="empty">No matching documents found.</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $documents->links() }}</div></div>
@endsection
