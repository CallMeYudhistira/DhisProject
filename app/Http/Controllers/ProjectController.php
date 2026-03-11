<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url|max:255',
        ]);

        $data = $request->only(['title', 'description', 'url']);

        if ($request->hasFile('preview')) {
            $image = $request->file('preview');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/projects');
            
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image->move($destinationPath, $name);
            $data['preview'] = 'storage/projects/' . $name;
        }

        Project::create($data);

        return redirect('/projects');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'preview' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url|max:255',
        ]);

        $project = Project::findOrFail($id);
        $data = $request->only(['title', 'description', 'url']);

        if ($request->hasFile('preview')) {
            // Delete old image if it exists and is local
            if ($project->preview && str_starts_with($project->preview, 'storage/')) {
                $oldPath = base_path('public/' . $project->preview);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $image = $request->file('preview');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/projects');
            
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image->move($destinationPath, $name);
            $data['preview'] = 'storage/projects/' . $name;
        }

        $project->update($data);

        return redirect('/projects');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        
        if ($project->preview && str_starts_with($project->preview, 'storage/')) {
            $oldPath = base_path('public/' . $project->preview);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }
        
        $project->delete();

        return redirect('/projects');
    }
}
