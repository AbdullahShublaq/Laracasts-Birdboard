@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-4 py-4">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-gray-600 text-lg font-semibold">My Projects</h2>
            <a href="/projects/create" class="button" @click.prevent="$modal.show('new-project')">Add Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                @include('projects._card')
            </div>
        @empty
            <div>No Projects Yet.</div>
        @endforelse
    </main>

    <new-project-modal></new-project-modal>

@endsection