<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationDetail;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class EducationDetailController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $items = EducationDetail::orderBy('sort_order')->latest()->paginate(10);

        return view('admin.education-details.index', compact('items'));
    }

    public function create()
    {
        return view('admin.education-details.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image'] = $this->uploadImage($request->file('image'), 'education-details');
        EducationDetail::create($data);

        return redirect()->route('admin.education-details.index')->with('success', 'Education detail added.');
    }

    public function edit(EducationDetail $educationDetail)
    {
        return view('admin.education-details.form', ['item' => $educationDetail]);
    }

    public function update(Request $request, EducationDetail $educationDetail)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $this->deleteImage($educationDetail->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'education-details');
        }
        $educationDetail->update($data);

        return redirect()->route('admin.education-details.index')->with('success', 'Education detail updated.');
    }

    public function destroy(EducationDetail $educationDetail)
    {
        $this->deleteImage($educationDetail->image);
        $educationDetail->delete();

        return redirect()->route('admin.education-details.index')->with('success', 'Education detail deleted.');
    }

    private function validated(Request $request, bool $imageRequired = false): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:4096',
            'sort_order' => 'required|integer|min:0|max:9999',
        ]);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}
