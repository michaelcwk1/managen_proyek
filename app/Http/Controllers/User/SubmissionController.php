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
            $request->validate([
                'file' => 'required|file|mimes:zip,rar|max:10240',
            ]);

            if ($submission->user_id !== Auth::id()) {
                return back()->with('error', 'You are not authorized to revise this submission.');
            }

            if ($submission->status !== 'rejected') {
                return back()->with('error', 'Only rejected submissions can be revised.');
            }

            // Delete old file if exists
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store file in the public disk under submissions folder
            $file->storeAs('submissions', $fileName, 'public');

            // Save the correct path without 'public/' prefix
            $filePath = 'submissions/' . $fileName;

            $submission->update([
                'file_path' => $filePath,
                'status' => 'pending',
                'notes' => null,
                'submission_date' => now(),
                'reviewed_by' => null
            ]);

            $submission->task->update([
                'status' => 'pending_review'
            ]);

            return redirect()->route('user.submissions.index')
                ->with('success', 'Revision submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Submission Revision Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while submitting the revision.');
        }
    }
}
