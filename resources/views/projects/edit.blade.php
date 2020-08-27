@extends('layouts.app')
@section('content')
    <form action="{{ $project->path() }}" method="POST" class="lg:w-1/2 lg:mx-auto bg-card p-3 rounded-lg shadow mb-3 py-12 px-16 rounded shadow">
        @csrf
        @method('PATCH')
        <h1 class="text-2xl font-normal mb-10 text-center">Edit Your Project</h1>
        @include('projects._form')
        <div class="filed">
            <div class="control">
                <button type="submit" class="button mr-2">Update Project</button>
                <a href="{{ $project->path() }}">Cancel</a>
            </div>
        </div>
    </form>
@endsection