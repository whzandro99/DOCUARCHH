<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ArchiveLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    private const TYPES = ['letter', 'clearance', 'report'];

    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->where('document_number', 'like', "%{$term}%")
                  ->orWhere('title', 'like', "%{$term}%")
                  ->orWhere('sender', 'like', "%{$term}%")
                  ->orWhere('recipient', 'like', "%{$term}%");
            });
        }

        if ($request->filled('type') && in_array($request->type, self::TYPES, true)) {
            $query->where('document_type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('document_date', $request->date);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('documents.index', compact('documents'));
    }

 public function create()
{
    $document = new \App\Models\Document();

    return view('documents.create', compact('document'));
}

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $document = DB::transaction(function () use ($data, $request) {
            $year = now()->year;
            $prefixes = ['letter' => 'LTR', 'clearance' => 'CLR', 'report' => 'RPT'];
            $last = Document::where('document_type', $data['document_type'])
                ->where('year', $year)->lockForUpdate()->max('sequence_number');
            $sequence = ((int) $last) + 1;

            $data['year'] = $year;
            $data['sequence_number'] = $sequence;
            $data['document_number'] = $prefixes[$data['document_type']] . '-' . $year . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
            $data['created_by'] = $request->user()->id;

            if ($request->hasFile('attachment')) {
                $data['file_path'] = $request->file('attachment')->store('documents', 'public');
            }

            unset($data['attachment']);
            $doc = Document::create($data);
            ArchiveLog::create([
                'document_id' => $doc->id, 'user_id' => $request->user()->id,
                'action' => 'Archived', 'details' => 'Document record created.',
            ]);
            return $doc;
        });

        return redirect()->route('documents.show', $document)->with('success', 'Document archived successfully.');
    }

    public function show(Document $document)
    {
        ArchiveLog::create([
            'document_id' => $document->id, 'user_id' => auth()->id(),
            'action' => 'Retrieved', 'details' => 'Document record viewed.',
        ]);
        $document->load(['logs.user', 'creator']);

        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $this->validated($request, true);
        if ($request->hasFile('attachment')) {
            if ($document->file_path) Storage::disk('public')->delete($document->file_path);
            $data['file_path'] = $request->file('attachment')->store('documents', 'public');
        }
        unset($data['attachment']);
        $document->update($data);

        ArchiveLog::create([
            'document_id' => $document->id, 'user_id' => $request->user()->id,
            'action' => 'Updated', 'details' => 'Document record updated.',
        ]);

        return redirect()->route('documents.show', $document)->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document record deleted.');
    }

    private function validated(Request $request, bool $update = false): array
    {
        return $request->validate([
            'document_type' => ['required', Rule::in(self::TYPES)],
            'title' => ['required', 'string', 'max:200'],
            'sender' => ['required', 'string', 'max:150'],
            'recipient' => ['nullable', 'string', 'max:150'],
            'document_date' => ['required', 'date'],
            'office' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
        ]);
    }
}
