<div>
    <h2 class="text-2xl font-bold mb-4">
        Checkout Membership
    </h2>

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <p>
        Paket: <strong>{{ $membership['name'] }}</strong>
    </p>

    <p>
        Harga:
        <strong>
            Rp {{ number_format($membership['price'], 0, ',', '.') }}
        </strong>
    </p>

    <button wire:click="pay"
        class="mt-6 w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 disabled:opacity-50"
        wire:loading.attr="disabled">
        <span wire:loading.remove>Bayar Sekarang</span>
        <span wire:loading>Memproses...</span>
    </button>

    {{-- Midtrans Snap Script --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        // Bungkus dalam event listener ini agar script jalan setelah Livewire siap
        document.addEventListener('livewire:initialized', () => {

            // Gunakan Livewire.on untuk menangkap dispatch dari PHP
            Livewire.on('openMidtransPopup', (data) => {

                // Debugging: Cek apakah token masuk ke console browser
                console.log('Snap Token diterima:', data.snapToken);

                // Tampilkan Popup
                window.snap.pay(data.snapToken, {
                    onSuccess: function (result) {
                        window.location.href = '/dashboard?status=success';
                    },
                    onPending: function (result) {
                        window.location.href = '/dashboard?status=pending';
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal!');
                    },
                    onClose: function () {
                        alert('Kamu menutup popup sebelum membayar');
                    }
                });
            });
        });
    </script>
</div>