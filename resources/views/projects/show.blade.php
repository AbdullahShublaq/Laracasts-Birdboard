@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-default text-lg font-semibold">
                <a href="/projects" class="text-blue-500">My Projects</a> / {{ $project->title }}
            </p>

            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img class="rounded-full w-8 mr-2"
                         src="{{ gravatar_url($member->email) }}"
                         alt="{{ $member->name }}'s avatar"
                         title="{{ $member->name }}">
                @endforeach

                <img class="rounded-full w-8 mr-2"
                     src="{{ gravatar_url($project->owner->email) }}"
                     alt="{{ $project->owner->name }}'s avatar"
                     title="{{ $project->owner->name }}">

                <a href="{{ $project->path() . '/edit' }}" class="button ml-4">
                    Edit Project
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-default text-lg font-semibold mb-3">Tasks</h2>
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center">
                                    <input class="bg-card text-default w-full py-1 px-2 mr-2 {{ $task->completed ? 'line-through text-muted' : '' }}"
                                           name="body" value="{{ $task->body }}">
                                    <input type="checkbox" name="completed"
                                           onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST" class="flex">
                            @csrf
                            <input placeholder="Add a new task..." name="body" class="bg-card text-default w-full p-2">
                        </form>
                    </div>
                </div>
                <div>
                    <h2 class="text-default text-lg font-semibold mb-3">General Notes</h2>
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="content mb-2">
                        <textarea
                                name="notes"
                                class="card w-full {{ $errors->has('notes') ? ' border-red-500' : ''}}"
                                style="min-height: 200px"
                                placeholder="Anything special that you want to make a note of?">{{ $project->notes }}</textarea>
                            @error('notes')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-10">
                @include('projects._card')
                @include('projects.activity._card')
                @can('manage', $project)
                    @include('projects._invite')
                @endcan
            </div>
        </div>
    </main>

@endsection