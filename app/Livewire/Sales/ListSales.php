<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Barryvdh\DomPDF\Facade\Pdf;

class ListSales extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Sale::query()->with(['customer','saleItems']))
            ->columns([
                TextColumn::make('customer.name')
                ->sortable(),
                TextColumn::make('saleItems.item.name')
                ->label('Sold Items')
                ->bulleted()
                ->limitList(2)
                ->expandableLimitedList(),
                TextColumn::make('total')
                ->money()
                ->sortable(),
                TextColumn::make('discount')
                ->money(),
                TextColumn::make('paid_amount')
                ->money(),
                TextColumn::make('paymentMethod.name'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('delete')
                ->requiresConfirmation()
                ->color('danger')
                ->action(fn (Sale $record) => $record->delete())
                ->successNotification(
                     Notification::make()
                        ->title('Sale Deleted successfully')
                        ->success()
                )
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function downloadPdf()
    {
        // Security Check
        if (! auth()->user()->canExportReport()) {
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Upgrade membership Anda untuk fitur ini.')
                ->danger()
                ->send();
            return;
        }

        // Proses Download
        $sales = Sale::with(['user', 'customer', 'saleItems.item'])->latest()->get();
        $pdf = Pdf::loadView('pdf.sales-report', ['sales' => $sales]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan-penjualan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function render(): View
    {
        return view('livewire.sales.list-sales');
    }
}
