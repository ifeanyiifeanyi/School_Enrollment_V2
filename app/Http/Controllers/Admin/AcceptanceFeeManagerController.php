<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcceptanceFee;
use Illuminate\Http\Request;

class AcceptanceFeeManagerController extends Controller
{
    /**
     * Display a listing of the resource.
    */

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcceptanceFee $acceptanceFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcceptanceFee $acceptanceFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcceptanceFee $acceptanceFee)
    {
        //
    }
}
