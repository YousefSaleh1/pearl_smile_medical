<?php

namespace App\Filament\Resources\BlogResource\Pages;

use Filament\Actions;
use App\Filament\Resources\BlogResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    public ?string $activeTab = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    

}