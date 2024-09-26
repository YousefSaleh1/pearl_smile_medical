        <video width="380" height="340" style="margin:10px;" controls>
            <source src="{{  asset($record->videos)  }}" {{ $record->type }}>
            Your browser does not support the video tag.
        </video>
