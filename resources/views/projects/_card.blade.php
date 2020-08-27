<div class="flex flex-col card" style="height: 200px">
    <h3 class="font-semibold text-xl py-4 -ml-5 border-l-4 border-blue-500 pl-4 mb-3">
        <a href="{{ $project->path() }}" class="text-default">{{ $project->title }}</a>
    </h3>
    <div class="flex-1 text-default mb-4">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>

    @can('manage', $project)
        <footer>
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs bg-red-500 text-white rounded-lg py-1 px-2">Delete</button>
            </form>
        </footer>
    @endcan
</div>
