<div class="filed">
    <label for="title" class="label text-sm mb-2 block">Title</label>
    <div class="control mb-2">
        <input type="text"
               class="input bg-transparent border border-gray-500 rounded p-2 text-sm w-full{{ $errors->has('title') ? ' border-red-500' : '' }}"
               name="title"
               placeholder="Title"
               value="{{ $project->title }}"
        >
        @error('title')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
</div>
<div class="filed">
    <label for="description" class="label text-sm mb-2 block">Description</label>
    <div class="control mb-2">
        <textarea
                style="height: 150px;"
                class="textarea bg-transparent border border-gray-500 rounded p-2 text-sm w-full{{ $errors->has('title') ? ' border-red-500' : '' }}"
                name="description"
                placeholder="Description"
        >{{ $project->description }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
</div>
