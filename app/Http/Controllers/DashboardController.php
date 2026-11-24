<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ArchiveLog;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'all' => Document::count(),
            'letter' => Document::where('document_type', 'letter')->count(),
            'clearance' => Document::where('document_type', 'clearance')->count(),
            'report' => Document::where('document_type', 'report')->count(),
        ];

        $recentDocuments = Document::latest()->take(6)->get();
        $recentLogs = ArchiveLog::with(['document', 'user'])->latest()->take(8)->get();

        return view('dashboard', compact('counts', 'recentDocuments', 'recentLogs'));
    }
}
