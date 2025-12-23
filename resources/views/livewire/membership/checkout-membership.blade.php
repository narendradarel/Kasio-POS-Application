<div>
        <h2 class="text-2xl font-bold mb-4">
            Checkout Membership
        </h2>

        <p>
            Paket: <strong>{{ $membership['name'] }}</strong>
        </p>

        <p>
            Harga:
            <strong>
                Rp {{ number_format($membership['price'], 0, ',', '.') }}
            </strong>
        </p>

        <button
            wire:click="pay"
            class="mt-6 w-full bg-green-600 text-white py-3 rounded-xl"
        >
            Bayar Sekarang
        </button>
</div>
