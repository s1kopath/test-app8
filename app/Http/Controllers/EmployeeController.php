<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\FileExists;

use function PHPUnit\Framework\fileExists;

class EmployeeController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required|gt:0',
            'email' => 'required|email',
            'date_of_birth' => 'required|date',
            'picture' => 'required',
        ]);

        // dd($request->all());
        $file_name='';
        if ($request -> hasFile('picture')) {
            $file = $request -> file('picture');
            if ($file -> isValid()) {
                $file_name = date('Ymdhms').'.'.$file -> getClientOriginalExtension();
                $file -> storeAs('/employees', $file_name);
            }
        }

        Employee::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'picture' => $file_name,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->back()->with('success', 'Employee added successfully');
    }
    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        $image_path = public_path().'/storage/employees/'.$employee->picture;
        if (FileExists($image_path)) {
            unlink($image_path);
        }
        return redirect()->back()->with('success', 'Employee deleted successfully');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $employee = Employee::find($request->id);

        $file_name=$employee->picture;

        if ($request -> hasFile('picture')) {
            $image_path = public_path().'/storage/employees/'.$employee->picture;
            if (FileExists($image_path)) {
                unlink($image_path);
            }

            $file = $request -> file('picture');
            if ($file -> isValid()) {
                $file_name = date('Ymdhms').'.'.$file -> getClientOriginalExtension();
                $file -> storeAs('/employees', $file_name);
            }
        }

        $employee->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'picture' => $file_name,
        ]);

        return redirect()->back()->with('success', 'Updated Successfully');
    }
}
