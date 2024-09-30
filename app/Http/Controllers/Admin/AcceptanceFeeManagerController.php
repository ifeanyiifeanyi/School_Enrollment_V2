<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use Illuminate\Support\Facades\DB;
use App\Mail\AcceptanceFeePaidMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AcceptanceFeesExport;

class AcceptanceFeeManagerController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'department' => 'nullable|string',
        ]);

        $query = AcceptanceFee::with(['user', 'user.student'])
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$request->start_date, $request->end_date]);

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $acceptanceFees = $query->get();

        $exportData = $acceptanceFees->map(function ($fee) {
            return [
                'application_number' => $fee->user->student->application_unique_number,
                'first_name' => $fee->user->first_name,
                'last_name' => $fee->user->last_name,
                'other_names' => $fee->user->other_names ?? '',
            ];
        });

        $fileName = 'paid_acceptance_fees_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new AcceptanceFeesExport($exportData), $fileName);
    }

    public function index(Request $request)
    {
        $query = AcceptanceFee::with(['user', 'user.student']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'LIKE', "%{$search}%")
                            ->orWhere('last_name', 'LIKE', "%{$search}%")
                            ->orWhere('other_names', 'LIKE', "%{$search}%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name, ' ', COALESCE(other_names, '')) LIKE ?", ["%{$search}%"]);
                    })
                    ->orWhereHas('user.student', function ($studentQuery) use ($search) {
                        $studentQuery->where('application_unique_number', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('department', 'LIKE', "%{$search}%");
            });
        }

        $acceptanceFees = $query->latest('paid_at')->get();
        return view('admin.acceptanceFees.index', compact('acceptanceFees'));
    }


    public function show(AcceptanceFee $acceptanceFee)
    {
        return view('admin.acceptanceFees.show', compact('acceptanceFee'));
    }

    public function manualApproval(Request $request, $acceptanceFeeId)
    {
        try {
            DB::beginTransaction();

            $acceptanceFee = AcceptanceFee::findOrFail($acceptanceFeeId);
            $user = User::findOrFail($acceptanceFee->user_id);

            $acceptanceFee->update([
                'status' => 'paid',
                'paid_at' => now(),
                // 'approved_by' => Auth::id(),
            ]);

            DB::commit();

            // Send email notification
            $this->sendAcceptanceFeePaidEmail($user, $acceptanceFee);

            return redirect()->back()->with('success', 'Acceptance fee manually approved and email sent.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error manually approving acceptance fee', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while approving the acceptance fee.');
        }
    }

    private function sendAcceptanceFeePaidEmail(User $user, AcceptanceFee $acceptanceFee)
    {
        try {
            Mail::to($user->email)->send(new AcceptanceFeePaidMail($user, $acceptanceFee));
        } catch (\Exception $e) {
            Log::error('Error sending acceptance fee paid email', ['message' => $e->getMessage()]);
            // Consider how you want to handle email sending failures
        }
    }


    public function destroy(AcceptanceFee $acceptanceFee)
    {
        $acceptanceFee->delete();

        return redirect()->back()
            ->with([
                'alert-type' => 'success',
                'message' => 'Acceptance fee record has been deleted successfully.',
            ]);
    }
}
