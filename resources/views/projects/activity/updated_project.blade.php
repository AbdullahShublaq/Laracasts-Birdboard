@if(count($activity->changes['after']) == 1)
    <span class="text-blue-500">{{ $activity->user->name }}</span> Updated The <span class="text-red-500">{{ key($activity->changes['after']) }}</span> Of The Project.
@else
    <span class="text-blue-500">{{ $activity->user->name }}</span> Updated The Project.
@endif