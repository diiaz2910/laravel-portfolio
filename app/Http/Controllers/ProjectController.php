<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\models\Project;
use App\models\Skill;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $projects = ProjectResource::collection(Project::with('skill')->get());
        return Inertia::render('Projects/Index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all();
        return Inertia::render('Projects/Create', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Creating validation rules */
        $request->validate([
            'image' => ['required', 'image'],
            'name' => ['required', 'min:3'],
            'skill_id' => ['required']
        ]);

        if ($request->hasFile('image')){
            $image = $request->file('image')->store('projects');
            Project::create([
                'skill_id' => $request->skill_id,
                'name' => $request->name,
                'image' => $image,
                'project_url' => $request->project_url
            ]);

            return Redirect::route('projects.index');
        }

        return redirect()->back();
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
    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', compact('project'));
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
