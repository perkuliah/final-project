<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Keuangan Per Pelapor</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2C3E50;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #2C3E50;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #7F8C8D;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #2C3E50;
            color: white;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #34495E;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #BDC3C7;
        }
        .total-row {
            background-color: #34495E;
            color: white;
            font-weight: bold;
        }
        .saldo-positif { color: #27AE60; }
        .saldo-negatif { color: #E74C3C; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #7F8C8D;
            font-size: 10px;
            border-top: 1px solid #ECF0F1;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan Per Pelapor</h1>
        <p>Dibuat pada: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th class="text-left" style="width: 25%;">Nama Pelapor</th>
                <th class="text-center" style="width: 10%;">Jumlah Laporan</th>
                <th class="text-right" style="width: 15%;">Total Pemasukan</th>
                <th class="text-right" style="width: 15%;">Total Pengeluaran</th>
                <th class="text-right" style="width: 15%;">Saldo</th>
                <th class="text-center" style="width: 15%;">Status Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($data as $nama => $item)
            <tr>
                <td class="text-center">{{ $counter++ }}</td>
                <td class="text-left">{{ $nama }}</td>
                <td class="text-center">{{ $item['jumlah_laporan'] }}</td>
                <td class="text-right">Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</td>
                <td class="text-center {{ $item['saldo'] >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                    {{ $item['saldo'] >= 0 ? 'Positif' : 'Negatif' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-center"><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{ $totalLaporan }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
                <td class="text-center {{ $totalSaldo >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                    <strong>{{ $totalSaldo >= 0 ? 'Positif' : 'Negatif' }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Laporan Keuangan</p>
    </div>
</body>
</html>
