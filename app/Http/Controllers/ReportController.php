<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->filled('type') && in_array($request->type, ['letter', 'clearance', 'report'], true)) {
            $query->where('document_type', $request->type);
        }
        if ($request->filled('from')) $query->whereDate('document_date', '>=', $request->from);
        if ($request->filled('to')) $query->whereDate('document_date', '<=', $request->to);

        $documents = $query->latest('document_date')->paginate(15)->withQueryString();
        $summary = [
            'letter' => (clone $query)->where('document_type', 'letter')->count(),
            'clearance' => (clone $query)->where('document_type', 'clearance')->count(),
            'report' => (clone $query)->where('document_type', 'report')->count(),
            'total' => (clone $query)->count(),
        ];

        return view('reports.index', compact('documents', 'summary'));
    }
}
