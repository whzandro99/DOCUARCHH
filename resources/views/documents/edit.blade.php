@extends('layouts.app')
@section('title','Edit document')
@section('heading','Edit document record')
@section('content')
<div class="form-panel"><div class="form-intro"><h2>Update {{ $document->document_number }}</h2><p class="muted">The original document number will remain unchanged.</p></div>
<form method="POST" action="{{ route('documents.update',$document) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="form-grid">
<div class="field"><label>Document type *</label><select name="document_type" required><option value="">Select type</option><option value="letter" @selected(old('document_type',$document->document_type)==='letter')>Letter</option><option value="clearance" @selected(old('document_type',$document->document_type)==='clearance')>Clearance Form</option><option value="report" @selected(old('document_type',$document->document_type)==='report')>Report</option></select></div>
<div class="field"><label>Document title *</label><input name="title" value="{{ old('title',$document->title) }}" required maxlength="200" placeholder="Enter document title"></div>
<div class="field"><label>Sender *</label><input name="sender" value="{{ old('sender',$document->sender) }}" required placeholder="Name or originating office"></div>
<div class="field"><label>Recipient</label><input name="recipient" value="{{ old('recipient',$document->recipient) }}" placeholder="Recipient name or office"></div>
<div class="field"><label>Document date *</label><input type="date" name="document_date" value="{{ old('document_date',optional($document->document_date)->format('Y-m-d')) }}" required></div>
<div class="field"><label>Responsible office *</label><input name="office" value="{{ old('office',$document->office) }}" required placeholder="e.g. Records Office"></div>
<div class="field full-field"><label>Description / notes</label><textarea name="description" rows="4" placeholder="Additional details (optional)">{{ old('description',$document->description) }}</textarea></div>
<div class="field full-field"><label>Digital attachment (optional)</label><input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"><small class="hint">PDF, DOC, DOCX, JPG or PNG · Maximum 10 MB</small></div>
</div>

<div class="form-actions"><a class="btn light" href="{{ route('documents.show',$document) }}">Cancel</a><button class="btn primary" type="submit">Save changes</button></div></form></div>
@endsection
