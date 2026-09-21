<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacultyStaff;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class FacultyStaffController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $items = FacultyStaff::orderBy('sort_order')->latest()->paginate(10);

        return view('admin.faculty-staff.index', compact('items'));
    }

    public function create()
    {
        return view('admin.faculty-staff.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->uploadImage($request->file('image'), 'faculty-staff');
        FacultyStaff::create($data);

        return redirect()->route('admin.faculty-staff.index')->with('success', 'Faculty/staff profile added.');
    }

    public function edit(FacultyStaff $facultyStaff)
    {
        return view('admin.faculty-staff.form', ['item' => $facultyStaff]);
    }

    public function update(Request $request, FacultyStaff $facultyStaff)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $this->deleteImage($facultyStaff->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'faculty-staff');
        }
        $facultyStaff->update($data);

        return redirect()->route('admin.faculty-staff.index')->with('success', 'Faculty/staff profile updated.');
    }

    public function destroy(FacultyStaff $facultyStaff)
    {
        $this->deleteImage($facultyStaff->image);
        $facultyStaff->delete();

        return redirect()->route('admin.faculty-staff.index')->with('success', 'Faculty/staff profile deleted.');
    }

    private function validated(Request $request, bool $imageRequired = false): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'designation' => 'required|string|max:150',
            'short_description' => 'nullable|string|max:1000',
            'detailed_description' => 'nullable|string',
            'qualification' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:4096',
            'sort_order' => 'required|integer|min:0|max:9999',
        ]);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}
