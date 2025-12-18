<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penilaian Kinerja Pegawai Non-ASN</title>
    <style>
        @page {
            margin: 2cm 2.5cm 2cm 2.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        
        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat .logo-container {
            margin-bottom: 5px;
        }
        .kop-surat h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .kop-surat h3 {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }
        .kop-surat p {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin: 30px 0 20px 0;
        }
        .judul-laporan h1 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0 0 5px 0;
        }
        .judul-laporan p {
            font-size: 12pt;
            margin: 0;
        }
        
        /* Nomor Surat */
        .nomor-surat {
            margin-bottom: 20px;
        }
        .nomor-surat table {
            border: none;
        }
        .nomor-surat td {
            border: none;
            padding: 2px 5px;
            vertical-align: top;
            font-size: 12pt;
        }
        
        /* Paragraf */
        .paragraf {
            text-align: justify;
            text-indent: 1.27cm;
            margin-bottom: 15px;
        }
        
        /* Tabel Data */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .data-table td.text-left {
            text-align: left;
        }
        .data-table .highlight {
            background-color: #ffffcc;
            font-weight: bold;
        }
        
        /* Section */
        .section {
            margin: 20px 0;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        /* Kesimpulan */
        .kesimpulan {
            margin: 25px 0;
            padding: 15px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }
        .kesimpulan-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        
        /* Tanda Tangan */
        .ttd-container {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-box p {
            margin: 3px 0;
        }
        .ttd-space {
            height: 70px;
        }
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
        }
        
        /* Catatan Kaki */
        .catatan-kaki {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 9pt;
            color: #666;
        }
        
        /* Clear float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        /* List */
        .list-kriteria {
            margin: 10px 0 10px 20px;
        }
        .list-kriteria li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <h2>PEMERINTAH KABUPATEN SUMBAWA</h2>
        <h3>DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK</h3>
        <p>Jl. Garuda No. 1 Sumbawa Besar, Telp. (0371) 123456, Fax. (0371) 123457</p>
        <p>Email: diskominfotiksan@sumbawakab.go.id | Website: www.diskominfotiksan.sumbawakab.go.id</p>
    </div>

    <!-- Judul Laporan -->
    <div class="judul-laporan">
        <h1>LAPORAN HASIL PENILAIAN KINERJA</h1>
        <h1>PEGAWAI NON APARATUR SIPIL NEGARA (NON-ASN)</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</p>
    </div>

    <!-- Nomor Surat -->
    <div class="nomor-surat">
        <table>
            <tr>
                <td style="width: 80px;">Nomor</td>
                <td style="width: 10px;">:</td>
                <td>800/____/DISKOMINFOTIKSAN/{{ date('Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>1 (satu) berkas</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>Laporan Hasil Penilaian Kinerja Pegawai Non-ASN</td>
            </tr>
        </table>
    </div>

    <!-- Pendahuluan -->
    <div class="section">
        <p class="paragraf">
            Berdasarkan hasil penilaian kinerja pegawai Non Aparatur Sipil Negara (Non-ASN) pada Dinas Komunikasi, Informatika dan Statistik Kabupaten Sumbawa periode <strong>{{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</strong>, dengan ini kami sampaikan laporan hasil penilaian sebagai berikut:
        </p>
    </div>

    <!-- Dasar Penilaian -->
    <div class="section">
        <p class="section-title">I. DASAR PENILAIAN</p>
        <p style="margin-left: 20px;">Penilaian kinerja pegawai Non-ASN dilakukan berdasarkan indikator yang telah ditetapkan oleh Dinas Komunikasi, Informatika dan Statistik dengan menggunakan metode <strong>Multi-Factor Evaluation Process (MFEP)</strong>.</p>
    </div>

    <!-- Kriteria Penilaian -->
    <div class="section">
        <p class="section-title">II. KRITERIA PENILAIAN</p>
        <p style="margin-left: 20px;">Kriteria yang digunakan dalam penilaian kinerja adalah sebagai berikut:</p>
        <table class="data-table" style="width: 80%; margin-left: 20px;">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 80px;">Kode</th>
                    <th>Kriteria</th>
                    <th style="width: 100px;">Bobot</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $i => $k)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $k->kode }}</td>
                    <td class="text-left">{{ $k->nama }}</td>
                    <td>{{ number_format($k->bobot * 100, 0) }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Bobot</th>
                    <th>100%</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Metode Perhitungan -->
    <div class="section">
        <p class="section-title">III. METODE PERHITUNGAN</p>
        <p style="margin-left: 20px;">Perhitungan nilai akhir menggunakan rumus MFEP:</p>
        <p style="margin-left: 40px; font-style: italic;"><strong>Nilai Total = Σ (Bobot Kriteria × Nilai Kriteria)</strong></p>
        <p style="margin-left: 20px;">Skala penilaian yang digunakan: 1 (Sangat Kurang), 2 (Kurang), 3 (Cukup), 4 (Baik), 5 (Sangat Baik)</p>
    </div>

    <!-- Data Nilai -->
    <div class="section">
        <p class="section-title">IV. DATA NILAI PEGAWAI</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th class="text-left">Nama Pegawai</th>
                    @foreach($kriteria as $k)
                    <th style="width: 50px;">{{ $k->kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $i => $h)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-left">{{ $h->pegawai->nama }}</td>
                    @foreach($kriteria as $k)
                    <td>{{ $nilaiMatrix[$h->pegawai_id][$k->id] ?? '-' }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Hasil Ranking -->
    <div class="section">
        <p class="section-title">V. HASIL PERHITUNGAN DAN PERINGKAT</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Peringkat</th>
                    <th class="text-left">Nama Pegawai</th>
                    <th class="text-left">Jabatan</th>
                    <th class="text-left">Unit Kerja</th>
                    <th style="width: 80px;">Nilai MFEP</th>
                    <th style="width: 80px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr class="{{ $h->ranking_mfep == 1 ? 'highlight' : '' }}">
                    <td>{{ $h->ranking_mfep }}</td>
                    <td class="text-left">{{ $h->pegawai->nama }}</td>
                    <td class="text-left">{{ $h->pegawai->jabatan }}</td>
                    <td class="text-left">{{ $h->pegawai->unit_kerja }}</td>
                    <td>{{ number_format($h->nilai_mfep, 4) }}</td>
                    <td>
                        @if($h->ranking_mfep == 1)
                        Terbaik
                        @elseif($h->ranking_mfep <= 3)
                        Top 3
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Kesimpulan -->
    <div class="kesimpulan">
        <p class="kesimpulan-title">VI. KESIMPULAN DAN REKOMENDASI</p>
        <p style="text-align: justify;">
            Berdasarkan hasil perhitungan menggunakan metode Multi-Factor Evaluation Process (MFEP), pegawai Non-ASN dengan kinerja terbaik pada periode {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }} adalah:
        </p>
        <table style="margin: 15px 0 15px 20px; border: none;">
            <tr>
                <td style="border: none; padding: 3px 10px 3px 0;">Nama</td>
                <td style="border: none; padding: 3px 5px;">:</td>
                <td style="border: none; padding: 3px;"><strong>{{ $hasil->first()->pegawai->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px 10px 3px 0;">Jabatan</td>
                <td style="border: none; padding: 3px 5px;">:</td>
                <td style="border: none; padding: 3px;">{{ $hasil->first()->pegawai->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px 10px 3px 0;">Unit Kerja</td>
                <td style="border: none; padding: 3px 5px;">:</td>
                <td style="border: none; padding: 3px;">{{ $hasil->first()->pegawai->unit_kerja ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px 10px 3px 0;">Nilai MFEP</td>
                <td style="border: none; padding: 3px 5px;">:</td>
                <td style="border: none; padding: 3px;"><strong>{{ number_format($hasil->first()->nilai_mfep ?? 0, 4) }}</strong></td>
            </tr>
        </table>
        <p style="text-align: justify; font-size: 11pt; font-style: italic;">
            Catatan: Laporan ini hanya bersifat rekomendasi hasil penilaian kinerja pegawai Non-ASN terbaik berdasarkan nilai total akhir, dan belum mencakup proses kebijakan lanjutan seperti promosi jabatan atau pemberian insentif.
        </p>
    </div>

    <!-- Penutup -->
    <div class="section">
        <p class="paragraf">
            Demikian laporan hasil penilaian kinerja pegawai Non-ASN ini kami sampaikan. Atas perhatian dan kerjasamanya diucapkan terima kasih.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="ttd-container clearfix">
        <div class="ttd-box">
            <p>Sumbawa Besar, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Dinas Komunikasi,</p>
            <p>Informatika dan Statistik</p>
            <div class="ttd-space"></div>
            <p class="ttd-nama">____________________________</p>
            <p>NIP. ____________________________</p>
        </div>
    </div>

    <!-- Catatan Kaki -->
    <div class="catatan-kaki" style="margin-top: 100px;">
        <p>Dokumen ini dicetak secara otomatis oleh Sistem Penilaian Kinerja Pegawai Non-ASN</p>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>
