<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Build query for attendance records with filters
            $query = DB::table('employee_attendances')
                ->join('users', 'employee_attendances.user_id', '=', 'users.id')
                ->select('employee_attendances.*', 'users.name as employee_name');
            
            // Apply filters if provided
            if ($request->has('date') && $request->date) {
                $query->where('employee_attendances.date', $request->date);
            }
            
            if ($request->has('status') && $request->status) {
                $query->where('employee_attendances.status', $request->status);
            }
            
            if ($request->has('employee_name') && $request->employee_name) {
                $query->where('users.name', 'like', '%' . $request->employee_name . '%');
            }
            
            // Get filtered records with pagination
            $attendanceRecords = $query->orderBy('employee_attendances.date', 'desc')
                ->orderBy('employee_attendances.check_in', 'desc')
                ->paginate(10)
                ->appends($request->except('page'));
            
            // Get employees for the dropdown
            $employees = DB::table('users')
                ->where('role', 'employee')
                ->select('id', 'name')
                ->get();
            
            // Get departments for filters
            $departments = DB::table('departments')->get();
            
            return view('dashboards.Admin.attendance.index', compact('attendanceRecords', 'employees', 'departments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load attendance records. Please try again.');
        }
    }

    /**
     * Display admin attendance index.
     */
    public function adminIndex(Request $request)
    {
        try {
            // Build query for admin attendance records with filters
            $query = DB::table('admin_attendances')
                ->join('users', 'admin_attendances.user_id', '=', 'users.id')
                ->select('admin_attendances.*', 'users.name as admin_name');
            
            // Apply filters if provided
            if ($request->has('date') && $request->date) {
                $query->where('admin_attendances.date', $request->date);
            }
            
            if ($request->has('status') && $request->status) {
                $query->where('admin_attendances.status', $request->status);
            }
            
            // Get filtered records with pagination
            $attendanceRecords = $query->orderBy('admin_attendances.date', 'desc')
                ->paginate(10)
                ->appends($request->except('page'));
            
            // Get admins for the dropdown
            $admins = DB::table('users')
                ->where('role', 'admin')
                ->select('id', 'name')
                ->get();
            
            return view('dashboards.Admin.attendance.admin', compact('attendanceRecords', 'admins'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admin attendance records. Please try again.');
        }
    }

    /**
     * Display employee attendance index.
     */
    public function employeeIndex(Request $request)
    {
        try {
            $userId = Auth::id();
            
            // Build query for employee's own attendance records with filters
            $query = DB::table('employee_attendances')
                ->where('user_id', $userId);
            
            // Apply filters if provided
            if ($request->has('month') && $request->month) {
                $query->whereMonth('date', $request->month);
            }
            
            if ($request->has('year') && $request->year) {
                $query->whereYear('date', $request->year);
            }
            
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
            
            // Get filtered records with pagination
            $attendanceRecords = $query->orderBy('date', 'desc')
                ->paginate(10)
                ->appends($request->except('page'));
            
            return view('dashboards.Employee.attendance.index', compact('attendanceRecords'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load your attendance records. Please try again.');
        }
    }

    /**
     * Display biometric attendance index.
     */
    public function biometricIndex(Request $request)
    {
        try {
            // Build query for biometric attendance records with filters
            $query = DB::table('biometric_attendances')
                ->join('users', 'biometric_attendances.user_id', '=', 'users.id')
                ->select('biometric_attendances.*', 'users.name as employee_name');
            
            // Apply filters if provided
            if ($request->has('date') && $request->date) {
                $query->whereDate('biometric_attendances.punch_time', $request->date);
            }
            
            // Get filtered records with pagination
            $biometricRecords = $query->orderBy('punch_time', 'desc')
                ->paginate(10)
                ->appends($request->except('page'));
            
            return view('dashboards.Admin.attendance.biometric', compact('biometricRecords'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load biometric records. Please try again.');
        }
    }

    /**
     * Handle clock in request.
     */
    public function clockIn(Request $request)
    {
        try {
            $userId = Auth::id();
            $today = date('Y-m-d');
            
            // Check if already clocked in today
            $existingRecord = DB::table('employee_attendances')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
            
            if ($existingRecord && $existingRecord->check_in) {
                return redirect()->back()->with('error', 'You have already clocked in today!');
            }
            
            if ($existingRecord) {
                // Update existing record
                DB::table('employee_attendances')
                    ->where('id', $existingRecord->id)
                    ->update([
                        'check_in' => date('H:i:s'),
                        'updated_at' => now()
                    ]);
            } else {
                // Create new record
                DB::table('employee_attendances')->insert([
                    'user_id' => $userId,
                    'date' => $today,
                    'check_in' => date('H:i:s'),
                    'status' => 'present',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            
            return redirect()->back()->with('success', 'Successfully clocked in!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clock in. Please try again.');
        }
    }

    /**
     * Handle clock out request.
     */
    public function clockOut(Request $request)
    {
        try {
            $userId = Auth::id();
            $today = date('Y-m-d');
            
            // Get today's attendance record
            $attendanceRecord = DB::table('employee_attendances')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->first();
            
            if (!$attendanceRecord) {
                return redirect()->back()->with('error', 'You have not clocked in today!');
            }
            
            if ($attendanceRecord->check_out) {
                return redirect()->back()->with('error', 'You have already clocked out today!');
            }
            
            // Calculate total hours
            $checkInTime = strtotime($today . ' ' . $attendanceRecord->check_in);
            $checkOutTime = strtotime($today . ' ' . date('H:i:s'));
            $totalMinutes = ($checkOutTime - $checkInTime) / 60;
            
            // Update record
            DB::table('employee_attendances')
                ->where('id', $attendanceRecord->id)
                ->update([
                    'check_out' => date('H:i:s'),
                    'total_hours' => $totalMinutes,
                    'updated_at' => now()
                ]);
            
            return redirect()->back()->with('success', 'Successfully clocked out!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clock out. Please try again.');
        }
    }

    /**
     * Handle manual entry request.
     */
    public function manualEntry(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half_day,on_leave',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string|max:500'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = $validator->validated();
            
            // Check if record already exists for this employee and date
            $existingRecord = DB::table('employee_attendances')
                ->where('user_id', $data['employee_id'])
                ->where('date', $data['date'])
                ->first();
            
            // Calculate total hours if both check in and check out are provided
            $totalMinutes = null;
            if ($data['check_in'] && $data['check_out']) {
                $checkInTime = strtotime($data['date'] . ' ' . $data['check_in']);
                $checkOutTime = strtotime($data['date'] . ' ' . $data['check_out']);
                $totalMinutes = ($checkOutTime - $checkInTime) / 60;
                
                // Validate that check out time is after check in time
                if ($checkOutTime <= $checkInTime) {
                    return redirect()->back()->with('error', 'Check out time must be after check in time.')->withInput();
                }
            }
            
            // Additional validation for status
            if (in_array($data['status'], ['absent', 'on_leave']) && ($data['check_in'] || $data['check_out'])) {
                return redirect()->back()->with('error', 'Cannot set check in/out times for absent or on leave status.')->withInput();
            }
            
            if ($existingRecord) {
                // Update existing record
                DB::table('employee_attendances')
                    ->where('id', $existingRecord->id)
                    ->update([
                        'check_in' => $data['check_in'],
                        'check_out' => $data['check_out'],
                        'total_hours' => $totalMinutes,
                        'status' => $data['status'],
                        'notes' => $data['notes'] ?? null,
                        'is_manual' => true,
                        'marked_by' => Auth::id(),
                        'updated_at' => now()
                    ]);
                    
                return redirect()->back()->with('success', 'Attendance record updated successfully!');
            } else {
                // Create new record
                DB::table('employee_attendances')->insert([
                    'user_id' => $data['employee_id'],
                    'date' => $data['date'],
                    'check_in' => $data['check_in'],
                    'check_out' => $data['check_out'],
                    'total_hours' => $totalMinutes,
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'is_manual' => true,
                    'marked_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                return redirect()->back()->with('success', 'Attendance entry added successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save attendance entry. Please try again.')->withInput();
        }
    }

    /**
     * Update an existing attendance record.
     */
    public function updateEntry(Request $request, $id)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'status' => 'required|in:present,absent,late,half_day,on_leave',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string|max:500'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $data = $validator->validated();
            
            // Calculate total hours if both check in and check out are provided
            $totalMinutes = null;
            if ($data['check_in'] && $data['check_out']) {
                $checkInTime = strtotime($data['date'] . ' ' . $data['check_in']);
                $checkOutTime = strtotime($data['date'] . ' ' . $data['check_out']);
                $totalMinutes = ($checkOutTime - $checkInTime) / 60;
                
                // Validate that check out time is after check in time
                if ($checkOutTime <= $checkInTime) {
                    return redirect()->back()->with('error', 'Check out time must be after check in time.')->withInput();
                }
            }
            
            // Additional validation for status
            if (in_array($data['status'], ['absent', 'on_leave']) && ($data['check_in'] || $data['check_out'])) {
                return redirect()->back()->with('error', 'Cannot set check in/out times for absent or on leave status.')->withInput();
            }
            
            // Update record
            DB::table('employee_attendances')
                ->where('id', $id)
                ->update([
                    'user_id' => $data['employee_id'],
                    'date' => $data['date'],
                    'check_in' => $data['check_in'],
                    'check_out' => $data['check_out'],
                    'total_hours' => $totalMinutes,
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'is_manual' => true,
                    'marked_by' => Auth::id(),
                    'updated_at' => now()
                ]);
                
            return redirect()->back()->with('success', 'Attendance record updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update attendance record. Please try again.')->withInput();
        }
    }

    /**
     * Delete an attendance record.
     */
    public function deleteEntry($id)
    {
        try {
            // Check if record exists
            $record = DB::table('employee_attendances')->where('id', $id)->first();
            
            if (!$record) {
                return redirect()->back()->with('error', 'Attendance record not found.');
            }
            
            // Delete record
            DB::table('employee_attendances')
                ->where('id', $id)
                ->delete();
                
            return redirect()->back()->with('success', 'Attendance record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete attendance record. Please try again.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}