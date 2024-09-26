@if ($record = $getRecord())
    @if ($record->videos()->exists())
        <video width="180" height="140" style="margin:10px;" controls>
            <source src="{{ $record->videos()->first()->path }}" {{ $record->type }}>
            Your browser does not support the video tag.
        </video>
    @endif
@endif