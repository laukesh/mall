<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\UserStatusAudit;
use Illuminate\Support\Facades\Gate;

class UserManagementController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
      //  $this->middleware(['auth','can:manage-users']);
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $users = User::when($q, function ($query) use ($q) {
            $s = '%'.$q.'%';
            $query->where('name', 'like', $s)->orWhere('email', 'like', $s);
        })->orderBy('id', 'desc')->paginate(20);

        return view('admin.users.index', compact('users','q'));
    }

    public function show($id)
    {
        $user = $this->users->findById($id);
        if (! $user) {
            return redirect()->route('admin.users.index')->withErrors(['user' => 'Not found']);
        }

        $roles = Role::all();
        $audits = UserStatusAudit::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('admin.users.show', compact('user','roles','audits'));
    }

    public function assignRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|string|exists:roles,name']);
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);

        $user->assignRole($request->role);
        return redirect()->back()->with('success', 'Role assigned');
    }

    public function revokeRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|string|exists:roles,name']);
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);

        $user->removeRole($request->role);
        return redirect()->back()->with('success', 'Role revoked');
    }

    public function activate($id)
    {
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);

        $this->users->update($user, ['is_active' => true, 'updated_by' => auth()->id()]);
        return redirect()->back()->with('success', 'User activated');
    }

    public function deactivate($id)
    {
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);

        $this->users->update($user, ['is_active' => false, 'updated_by' => auth()->id()]);
        return redirect()->back()->with('success', 'User deactivated');
    }

    public function audits($id)
    {
        $user = $this->users->findById($id);
        if (! $user) return redirect()->back()->withErrors(['user' => 'Not found']);

        $audits = UserStatusAudit::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(50);
        return view('admin.users.audits', compact('user','audits'));
    }
}
