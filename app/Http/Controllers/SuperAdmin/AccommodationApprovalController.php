<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccommodationApprovalController extends Controller
{
    /**
     * Display accommodations pending review and all accommodations.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $query = Accommodation::with(['resort', 'amenities'])->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $accommodations = $query->paginate(15);

        $counts = [
            'pending'  => Accommodation::where('status', 'pending')->count(),
            'approved' => Accommodation::where('status', 'approved')->count(),
            'rejected' => Accommodation::where('status', 'rejected')->count(),
            'all'      => Accommodation::count(),
        ];

        return view('super-admin.accommodations.index', compact('accommodations', 'status', 'counts'));
    }

    /**
     * Approve an accommodation request and publish it live.
     */
    public function approve(Accommodation $accommodation): RedirectResponse
    {
        $accommodation->update([
            'status'           => 'approved',
            'rejection_reason' => null,
        ]);

        return back()->with('success', "Accommodation '{$accommodation->name}' at {$accommodation->resort->name} has been APPROVED and is now live for public booking!");
    }

    /**
     * Reject an accommodation request with feedback.
     */
    public function reject(Request $request, Accommodation $accommodation): RedirectResponse
    {
        $reason = $request->input('rejection_reason', 'Does not comply with current municipal tourism safety or accreditation standards.');

        $accommodation->update([
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        return back()->with('info', "Accommodation '{$accommodation->name}' has been marked as rejected.");
    }
}
