<table>
    <thead>
        <tr>
            <th style="font-weight: bold;">No</th>
            <th style="font-weight: bold;">Nama</th>
            <th style="font-weight: bold;">No Surat</th>
            <th style="font-weight: bold;">Tanggal Acara</th>
            <th style="font-weight: bold;">Tanggal Pengiriman</th>
            <th style="font-weight: bold;">Metode Pemesanan</th>
            <th style="font-weight: bold;">Kecamatan</th>
            <th style="font-weight: bold;">UMKM</th>
            <th style="font-weight: bold;">Alamat</th>
            <th style="font-weight: bold;">Jumlah Produk</th>
            <th style="font-weight: bold;">Total Harga</th>
            <th style="font-weight: bold;">Total Pajak</th>
            <th style="font-weight: bold;">Total Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $key => $submission)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $submission->name }}</td>
                <td>{{ $submission->reference_number }}</td>
                <td>{{ \Carbon\Carbon::parse($submission->event_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($submission->delivery_date)->format('d/m/Y') }}</td>
                <td>{{ $submission->order_method->name }}</td>
                <td>{{ $submission->subdistrict }}</td>
                <td>{{ $submission->umkm }}</td>
                <td>{{ $submission->destinationAddress }}</td>
                <td>{{ $submission->total_qty }}</td>
                <td>{{ $submission->total_price }}</td>
                <td>{{ $submission->total_tax }}</td>
                <td>{{ $submission->total_payment }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
