<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrincipalMessage;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

/**
 * There is only ONE principal message, so this controller has just
 * an edit form and an update action (it creates the row the first time).
 */
class PrincipalMessageController extends Controller
{
    use ImageUploadTrait;

    public function edit()
    {
        $principal = PrincipalMessage::first();

        return view('admin.principal.form', compact('principal'));
    }

    public function update(Request $request)
    {
        $principal = PrincipalMessage::first();

        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'message'     => 'required|string',
            'photo'       => [
                $principal && $principal->photo ? 'nullable' : 'required',
                'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            ],
        ]);

        if ($request->hasFile('photo')) {
            if ($principal) {
                $this->deleteImage($principal->photo);
            }
            $data['photo'] = $this->uploadImage($request->file('photo'), 'principal');
        }

        $principal
            ? $principal->update($data)
            : PrincipalMessage::create($data);

        return back()->with('success', "Principal's message saved.");
    }
}
