<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
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

class ListCustomers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Customer::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('phone')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add Customer')
                    ->icon('heroicon-o-user-plus')
                    ->url(fn () => route('customers.create'))
                    ->disabled(fn () => ! auth()->user()->canCreateCustomer())
                    ->tooltip(
                        fn () => ! auth()->user()->canCreateCustomer()
                            ? 'Limit customer tercapai. Upgrade membership.'
                            : null
                    ),

                Action::make('upgrade')
                    ->label('Upgrade')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->url(route('membership.index'))
                    ->visible(fn () => ! auth()->user()->canCreateCustomer()),
            ])

            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn(Customer $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('Customer Deleted successfully')
                            ->success()
                    ),
                Action::make('edit')
                    ->url(fn(Customer $record): string => route('customer.update', $record))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.customer.list-customers');
    }
}
