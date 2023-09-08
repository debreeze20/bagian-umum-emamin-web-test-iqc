<table>
    <thead>
        <tr>
            <th style="font-weight: bold;">No</th>
            <th style="font-weight: bold;">Nama</th>
            <th style="font-weight: bold;">Pemilik</th>
            <th style="font-weight: bold;">Whatsapp</th>
            <th style="font-weight: bold;">Kecamatan</th>
            <th style="font-weight: bold;">Alamat</th>
            <th style="font-weight: bold;">MBR</th>
            <th style="font-weight: bold;">NIK</th>
            <th style="font-weight: bold;">NPWP</th>
            <th style="font-weight: bold;">SIUP / NIB</th>
            <th style="font-weight: bold;">No Referensi Bank</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($umkms as $key => $umkm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $umkm->name }}</td>
                <td>{{ $umkm->owner_name }}</td>
                <td>{{ $umkm->whatsapp_number }}</td>
                <td>{{ $umkm->subdistrict->name }}</td>
                <td>{{ $umkm->address }}</td>
                <td>{{ $umkm->is_mbr ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $umkm->nik_number }}</td>
                <td>{{ $umkm->npwp_number }}</td>
                <td>{{ $umkm->nib_number }}</td>
                <td>{{ $umkm->bank_reference_number }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
