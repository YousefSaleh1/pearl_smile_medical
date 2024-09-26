<?php
namespace App\Enums;
use Filament\Support\Contracts\HasLabel;
 
enum Category: string implements HasLabel
{
    case Photo = 'photo';
    case Video = 'video';
    
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Photo => 'Photo',
            self::Video => 'Video',
        };
    }
}