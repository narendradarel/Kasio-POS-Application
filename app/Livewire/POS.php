<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\SalesItem;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class POS extends Component
{
    // properties
    public $items;

    public $customers;

    public $paymentMethods;

    public $search = '';

    public $cart = [];

    // properties for checkout
    public $customer_id = null;

    public $payment_method_id = null;

    public $paid_amount = 0;

    public $discount_amount = 0; // flat amount not a percentage

    public $isLocked = false;

    public $dailyLimit = 0;

    public $todaySales = 0;

    public function mount()
    {
        // load all the items,
        // $this->items = Item::with([
        //     'inventory' => function ($builder) {
        //         $builder->where('quantity', '>', 0);
        //     }
        // ])
        //     ->where('status', 'active')
        //     ->get();

        $this->items = Item::whereHas('inventory', function ($builder) {
            $builder->where('quantity', '>', 0);
        })
            ->with('inventory')
            ->where('status', 'active')
            ->get();
        // load customers
        $this->customers = Customer::all();

        // load payment methods
        $this->paymentMethods = PaymentMethod::all();

        $user = Auth::user();
        $this->dailyLimit = $user->dailyPosLimit(); // Ambil limit (misal 20)
        $this->todaySales = $user->todayPosCount(); // Ambil jumlah trx hari ini

        // Cek apakah user boleh transaksi?
        if (! $user->canCreateSale()) {
            $this->isLocked = true; // Kunci tampilan

            // Opsional: Langsung kirim notifikasi saat masuk halaman
            Notification::make()
                ->title('Limit Harian Habis')
                ->body("Anda telah mencapai batas {$this->dailyLimit} transaksi hari ini.")
                ->danger()
                ->persistent() // Agar tidak hilang sendiri
                ->send();
        }

    }

    #[Computed]
    public function filteredItems()
    {
        if (empty($this->search)) {
            return $this->items;
        }

        return $this->items->filter(function ($item) {
            return str_contains(strtolower($item->name), strtolower($this->search))
                || str_contains(strtolower($item->sku), strtolower($this->search));
        });

    }

    #[Computed]
    public function subtotal()
    {
        return collect($this->cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    // placeholder for tax
    #[Computed]
    public function tax()
    {
        return $this->subtotal * 0.15; // 15%
    }

    #[Computed]
    public function totalBeforeDiscount()
    {
        return $this->subtotal + $this->tax;
    }

    #[Computed]
    public function total()
    {
        $discountedTotal = $this->totalBeforeDiscount - $this->discount_amount;

        return $discountedTotal;
    }

    #[Computed]
    public function change()
    {
        if ($this->paid_amount > $this->total) {
            return $this->paid_amount - $this->total;
        }

        return 0;
    }

    public function addToCart($itemId)
    {

        // access the item from db get its inventory
        $item = Item::find($itemId);

        // inventory
        $inventory = Inventory::where('item_id', $itemId)->first();
        if (! $inventory || $inventory->quantity <= 0) {
            Notification::make()
                ->title('This item is out of stock!')
                ->danger()
                ->send();

            return;
        }
        //
        if (isset($this->cart[$itemId])) {
            $currentQuantity = $this->cart[$itemId]['quantity'];
            if ($currentQuantity >= $inventory->quantity) {
                Notification::make()
                    ->title("Cannot add more. Only {$inventory->quantity} in stock")
                    ->danger()
                    ->send();

                return;
            }
            // add one items
            $this->cart[$itemId]['quantity']++;
        } else {
            $this->cart[$itemId] = [
                'id' => $item->id,
                'name' => $item->name,
                'sku' => $item->sku,
                'price' => $item->price,
                'quantity' => 1,
            ];
        }
    }

    // remove items from the cart
    public function removeFromCart($itemId)
    {
        unset($this->cart[$itemId]);
    }

    // update the quantity on the cart for that item
    public function updateQuantity($itemId, $quantity)
    {
        // ensure qunatoty of an item is not less than 1
        $quantity = max(1, (int) $quantity);

        // get inventory
        $inventory = Inventory::where('item_id', $itemId)->first();

        if ($quantity > $inventory->quantity) {
            Notification::make()
                ->title("Cannot add more. Only {$inventory->quantity} in stock")
                ->danger()
                ->send();
            $this->cart[$itemId]['quantity'] = $inventory->quantity;
        } else {
            $this->cart[$itemId]['quantity'] = $quantity;
        }
    }

    // checkout
    public function checkout()
    {

        if (! Auth::user()->canCreateSale()) {
            Notification::make()
                ->title('Transaksi Ditolak!')
                ->body('Kuota harian paket Membership Anda sudah habis. Silakan upgrade.')
                ->danger()
                ->send();

            return; // STOP PROSES DI SINI
        }

        // check if the cart is not empty
        if (empty($this->cart)) {
            Notification::make()
                ->title('Failed Sale!')
                ->body('Your cart is empty!')
                ->danger()
                ->send();

            return;
        }

        // basic validation for paid amount
        if ($this->paid_amount < $this->total) {
            Notification::make()
                ->title('Failed Sale!')
                ->body('Paid Amount is less than total!')
                ->danger()
                ->send();

            return;
        }

        // create the sale... db transaction
        try {
            // code...

            DB::beginTransaction();

            // create a sale
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total' => $this->total,
                'paid_amount' => $this->paid_amount,
                'customer_id' => $this->customer_id,
                'payment_method_id' => $this->payment_method_id,
                'discount' => $this->discount_amount,
            ]);

            // create the sale items

            foreach ($this->cart as $item) {
                SalesItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // update the stock
                $inventory = Inventory::where('item_id', $item['id'])->first();
                if ($inventory) {
                    $inventory->quantity -= $item['quantity'];
                    $inventory->save();
                }
            }

            DB::commit();

            // reset cart
            $this->cart = [];

            // reset other properties
            $this->search = '';
            $this->customer_id = null;
            $this->payment_method_id = null;
            $this->paid_amount = 0;
            $this->discount_amount = 0;

            Notification::make()
                ->title('Sale Completed')
                ->body('Do you want to print the receipt?')
                ->success()
                ->duration(10000)
                ->actions([
                    Action::make('print')
                        ->button()
                        ->label('Yes, Print Receipt')
                        ->url(route('sales.receipt', ['sale' => $sale->id]), shouldOpenInNewTab: true)
                        ->color('primary')
                        // ->url(route('sales.receipt', $sale))
                        ->openUrlInNewTab(false)
                        ->extraAttributes([
                            'onclick' => 'event.preventDefault(); printReceipt(this.href);',
                        ]),
                    // NotificationAction::make('cancel')
                    //     ->button()
                    //     ->label('No')
                    //     ->color('secondary'),
                ])
                ->send();

        } catch (\Exception $th) {
            DB::rollback();

            // Tampilkan pesan error ASLI dari sistem
            Notification::make()
                ->title('Failed Sale!')
                ->body('Error: '.$th->getMessage()) // <--- GANTI JADI INI
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.p-o-s');
    }
}
