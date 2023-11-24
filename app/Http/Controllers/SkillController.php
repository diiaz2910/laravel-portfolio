<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\models\Skill;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\SkillResource;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $skills = SkillResource::collection(Skill::all());
        return Inertia::render('Skills/Index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Skills/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Creating validation rules */
        $request->validate([
            'image' => ['required', 'image'],
            'name' => ['required', 'min:3']
        ]);

        if ($request->hasFile('image')){
            $image = $request->file('image')->store('skills');
            Skill::create([
                'name' => $request->name,
                'image' => $image
            ]);

            return Redirect::route('skills.index');
        }

        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return Inertia::render('Skills/Edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $image = $skill->image;
        $request->validate([
            'name' => ['required', 'min:3']
        ]);
        if ($request->hasFile('image')){
            Storage::delete($skill->image);
            $image = $request->file('image')->store('skills');
        };

        $skill->update([
            'name' => $request->name,
            'image' => $image
        ]);

        return redirect::route('skills.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $skill = Skill::find($request->input('skill_id'));

        if(!$skill){
            return response()->json(['message' => 'Skill not found'], 404);
        }

        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully']);
    }
}
