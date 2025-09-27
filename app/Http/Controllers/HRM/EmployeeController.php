<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeProfile;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(['employeeProfile', 'department', 'designation'])
            ->where('role', '!=', 'admin')
            ->paginate(15);
        
        return view('hrm.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        
        return view('hrm.employees.create', compact('departments', 'designations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        // Generate employee ID
        $lastEmployee = EmployeeProfile::latest('id')->first();
        $employeeId = 'EMP' . str_pad(($lastEmployee ? $lastEmployee->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        // Create user
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Default password
            'role' => 'employee',
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
        ]);

        // Handle profile picture upload
        $profilePicture = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create employee profile
        EmployeeProfile::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'joining_date' => $request->joining_date,
            'salary' => $request->salary,
            'bank_account' => $request->bank_account,
            'tax_id' => $request->tax_id,
            'profile_picture' => $profilePicture,
            'employment_type' => $request->employment_type,
        ]);

        return redirect()->route('hrm.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(User $employee)
    {
        $employee->load(['employeeProfile', 'department', 'designation']);
        return view('hrm.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        $employee->load('employeeProfile');
        
        return view('hrm.employees.edit', compact('employee', 'departments', 'designations'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'salary' => 'nullable|numeric|min:0',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'status' => 'required|in:active,inactive,terminated',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        // Update user
        $employee->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
        ]);

        // Handle profile picture upload
        $profilePicture = $employee->employeeProfile->profile_picture;
        if ($request->hasFile('profile_picture')) {
            if ($profilePicture) {
                Storage::disk('public')->delete($profilePicture);
            }
            $profilePicture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Update employee profile
        $employee->employeeProfile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'nationality' => $request->nationality,
            'salary' => $request->salary,
            'bank_account' => $request->bank_account,
            'tax_id' => $request->tax_id,
            'profile_picture' => $profilePicture,
            'employment_type' => $request->employment_type,
            'status' => $request->status,
        ]);

        return redirect()->route('hrm.employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        if ($employee->employeeProfile && $employee->employeeProfile->profile_picture) {
            Storage::disk('public')->delete($employee->employeeProfile->profile_picture);
        }
        
        $employee->delete();
        
        return redirect()->route('hrm.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
