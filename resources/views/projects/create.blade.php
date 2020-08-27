@extends('layouts.app')
@section('content')
    <form action="/projects" method="POST" class="lg:w-1/2 lg:mx-auto bg-white p-3 rounded-lg shadow mb-3 py-12 px-16 rounded shadow">
        @csrf
        <h1 class="text-2xl font-normal mb-10 text-center">Let's Star Something New</h1>
        @include('projects._form', ['project' => new App\Project])
        <div class="filed">
            <div class="control">
                <button type="submit" class="button mr-2">Add Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection