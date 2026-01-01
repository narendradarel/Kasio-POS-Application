<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListUsers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role')
                    ->searchable()
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add User')
                    ->icon('heroicon-o-user-plus')
                    ->url(fn () => route('users.create'))
                    // ✅ HAPUS disabled & tooltip (tidak ada limit user)
                    // ->disabled(fn () => ! auth()->user()->canCreateUser())
                    // ->tooltip(
                    //     fn () => ! auth()->user()->canCreateUser()
                    //         ? 'Limit user tercapai. Upgrade membership.'
                    //         : null
                    // ),
                
                // ✅ HAPUS action upgrade (tidak perlu lagi)
                // Action::make('upgrade')
                //     ->label('Upgrade')
                //     ->icon('heroicon-o-star')
                //     ->color('warning')
                //     ->url(route('membership.index'))
                //     ->visible(fn () => ! auth()->user()->canCreateUser()),
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (User $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('User Deleted successfully')
                            ->success()
                    ),
                Action::make('edit')
                    ->url(fn(User $record): string => route('user.update', $record))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.management.list-users');
    }
}
