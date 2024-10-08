@if ($getRecord()->videos()->exists())

    <iframe width="320" height="240"
        src="{{ $getRecord()->videos->first()->path }}"
        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
    </iframe>
@else
    <p>No video available</p>
@endif
