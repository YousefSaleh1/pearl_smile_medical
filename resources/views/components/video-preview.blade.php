@if ($getState())
    <div style="text-align: center;">
        <iframe width="100%" height="500" src="{{ $getState() }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
@else
    <p>No video preview available.</p>
@endif
