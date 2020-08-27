<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Project;

class ProjectsController extends Controller
{
    //
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }


    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());
        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    /**
     * @return array
     */
    protected function validateRequest(): array
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'min:3',
        ]);
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $form)
    {
//        $request->save();
//        $project->update($request->validated());

        return redirect($form->save()->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }

}