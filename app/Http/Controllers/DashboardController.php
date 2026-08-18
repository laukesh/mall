<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignPackage;
use App\Models\FeasibilityStudy;
use App\Models\Incident;
use App\Models\Land;
use App\Models\MobilizationPlan;
use App\Models\Payment;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Models\WorkPackage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'projectCount' => Project::count(),
            'landCount' => Land::count(),
            'feasibilityCount' => FeasibilityStudy::count(),
            'designPackageCount' => DesignPackage::count(),
            'workPackageCount' => WorkPackage::count(),
            'contractorCount' => Contractor::count(),
            'clientCount' => Client::count(),
            'userCount' => User::count(),
            'poCount' => PurchaseOrder::count(),
            'mobilizationCount' => MobilizationPlan::count(),
            'incidentCount' => Incident::where('status', '!=', 'Closed')->count(),
            'paymentTotal' => Payment::where('status', 'Completed')->sum('amount'),
            'recentProjects' => Project::orderByDesc('created_at')->limit(5)->get(),
            'recentAudits' => AuditLog::orderByDesc('created_at')->limit(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
