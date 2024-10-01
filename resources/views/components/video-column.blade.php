@if ($getRecord()->videos()->exists())
    <video width="320" height="240" controls>
        <source src="storage/{{ $getRecord()->videos->first()->path }}">
        Your browser does not support the video tag.
    </video>
@else
    <p>No video available</p>
@endif
