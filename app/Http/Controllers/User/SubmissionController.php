<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function indexSubmissions()
    {
        $submissions = Submission::with(['task.project'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('user.submissions.index', compact('submissions'));
    }

    public function showFeedback(Submission $submission)
    {
        // Check if submission belongs to user
        if ($submission->user_id !== Auth::id()) {
            return redirect()->route('user.submissions.index')
                ->with('error', 'You are not authorized to view this feedback.');
        }
        
        return view('user.submissions.feedback', compact('submission'));
    }

    public function reviseSubmission(Request $request, Submission $submission)
    {
        try {
            // Validate request
            $request->validate([
                'file' => 'required|file|mimes:zip,rar|max:10240', // Max 10MB
            ]);

            // Check if submission belongs to user
            if ($submission->user_id !== Auth::id()) {
                return back()->with('error', 'You are not authorized to revise this submission.');
            }

            // Check if submission is actually rejected
            if ($submission->status !== 'rejected') {
                return back()->with('error', 'Only rejected submissions can be revised.');
            }

            // Delete old file if exists
            if ($submission->file_path && Storage::exists($submission->file_path)) {
                Storage::delete($submission->file_path);
            }

            // Handle new file upload
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/submissions', $fileName); // Ensure the 'public' prefix


            // Update submission
            $submission->update([
                'file_path' => $filePath,
                'status' => 'pending', // Reset status to pending
                'notes' => null, // Clear previous rejection notes
                'submission_date' => now(),
                'reviewed_by' => null // Clear previous reviewer
            ]);

            // Update associated task status
            $submission->task->update([
                'status' => 'pending_review'
            ]);

            return redirect()->route('user.submissions.index')
                ->with('success', 'Revision submitted successfully!');

        } catch (\Exception $e) {
            Log::error('Submission Revision Error: ' . $e->getMessage());
            return back()->with('Berhasil Submit');
        }
    }
}