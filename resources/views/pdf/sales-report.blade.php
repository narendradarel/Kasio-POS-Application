<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e6e6e6; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan</h2>
        <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Customer</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->user->name ?? 'Deleted User' }}</td>
                    <td>{{ $sale->customer->name ?? 'Guest' }}</td>
                    <td class="text-right">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Grand Total</td>
                <td class="text-right">Rp {{ number_format($sales->sum('total'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>