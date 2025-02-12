<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['task.project', 'user'])
            ->latest('submission_date')
            ->paginate(10);

        return view('admin.reporting.report', compact('submissions'));
    }


    public function download($id)
    {
        try {
            $submission = Submission::findOrFail($id);

            // Check if file exists in public disk
            if (!Storage::disk('public')->exists($submission->file_path)) {
                return back()->with('error', 'File not found. Path: ' . $submission->file_path);
            }

            $fileName = basename($submission->file_path);
            $fullPath = storage_path('app/public/' . $submission->file_path);

            return response()->download($fullPath, $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Error downloading file: ' . $e->getMessage());
        }
    }





    public function approve(Submission $submission)
    {
        try {
            $submission->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Submission approved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error approving submission');
        }
    }

    public function reject(Request $request, Submission $submission)
    {
        try {
            $validated = $request->validate([
                'notes' => 'required|string|max:500'
            ]);

            $submission->update([
                'status' => 'rejected',
                'notes' => $validated['notes'],
                'reviewed_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', 'Submission rejected successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error rejecting submission');
        }
    }
}
