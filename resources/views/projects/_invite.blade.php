<div class="flex flex-col card mt-3" style="height: 200px">
    <h3 class="font-semibold text-xl py-4 -ml-5 border-l-4 border-blue-500 pl-4 mb-3">
        Invite a User
    </h3>

    <form action="{{ $project->path() . '/invitations' }}" method="POST">
        @csrf
        @error('email')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
        <input type="email" name="email" placeholder="Email Address" class="text-sm border border-gray-500 bg-transparent text-default py-1 px-2 rounded w-full mb-3">
        <button type="submit" class="text-xs bg-blue-500 text-white rounded-lg py-1 px-2">Invite</button>
    </form>

</div>