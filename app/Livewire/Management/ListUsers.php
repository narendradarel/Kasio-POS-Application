<?php

namespace App\Livewire\Management;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListUsers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

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
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add User')
                    ->icon('heroicon-o-user-plus')
                    ->url(fn () => route('users.create')),
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
                    ->visible(fn (User $record): bool => $record->id === auth()->id()) // 👈 hanya untuk dirinya sendiri
                    ->action(fn (User $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('User Deleted successfully')
                            ->success()
                    ),

                Action::make('edit')
                    ->url(fn (User $record): string => route('user.update', $record))
                    ->visible(fn (User $record): bool => $record->id === auth()->id()), // 👈 hanya untuk dirinya sendiri
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
