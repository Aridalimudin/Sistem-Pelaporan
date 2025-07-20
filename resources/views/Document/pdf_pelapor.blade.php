<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Laporan & Penyelesaian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
            padding: 20px;
            max-width: 210mm;
            margin: 0 auto;
        }

        .document-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .document-header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .document-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .status-box {
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .priority-notice {
            border: 1px solid #333;
            padding: 5px 10px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .section {
            margin-bottom: 15px;
            border: 1px solid #ccc;
        }

        .section-header {
            background-color: #f5f5f5;
            border-bottom: 1px solid #ccc;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 12px;
        }

        .section-content {
            padding: 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .detail-table td {
            padding: 3px 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .detail-table td:first-child {
            width: 120px;
            font-weight: bold;
            color: #555;
        }

        .detail-table td:nth-child(2) {
            width: 10px;
            text-align: center;
        }

        .incident-description {
            margin-top: 8px;
        }

        .incident-description h4 {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .incident-description p {
            text-align: justify;
            line-height: 1.5;
        }

        .resolution-text {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .evidence-list {
            margin-top: 8px;
        }

        .evidence-list ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 8px 0;
        }

        .evidence-list li {
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .note {
            font-style: italic;
            color: #666;
            margin-top: 8px;
            font-size: 10px;
        }

        /* Print optimization */
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }
            
            body {
                padding: 0;
                font-size: 10px;
                max-width: 100%;
            }
            
            .document-header h1 {
                font-size: 14px;
            }
            
            .section-header {
                font-size: 11px;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            .detail-table td {
                padding: 2px 6px;
            }
            
            .section-content {
                padding: 8px;
            }
            
            .document-info {
                font-size: 9px;
            }
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
                font-size: 10px;
            }
            
            .document-info {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-table td:first-child {
                width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="document-header">
        <h1>Ringkasan Laporan Penyelesaian</h1>
    </div>

    <div class="document-info">
        <p><strong>Kode Laporan:</strong> {{$reporter->code}}</p>
        <p><strong>Tanggal Selesai:</strong> {{$done->created_at->format('d F Y')}}</p>
    </div>

    <div class="status-box">
        STATUS LAPORAN: SELESAI DITANGANI
    </div>

    <div class="priority-notice">
        @if($reporter->urgency == 1)
            LAPORAN PRIORITAS RENDAH
        @elseif($reporter->urgency == 2)
            LAPORAN PRIORITAS SEDANG
        @elseif($reporter->urgency == 3)
            LAPORAN PRIORITAS TINGGI
        @endif
    </div>

    <div class="section">
        <div class="section-header">
            DETAIL LAPORAN
        </div>
        <div class="section-content">
            <table class="detail-table">
                <tr>
                    <td>Pelapor</td>
                    <td>:</td>
                    <td>{{$reporter->student?->name}}</td>
                </tr>
                <tr>
                    <td>NIS Pelapor</td>
                    <td>:</td>
                    <td>{{$reporter->student?->nis}}</td>
                </tr>
                  <tr>
                    <td>Email Pelapor</td>
                    <td>:</td>
                    <td>{{$reporter->student?->email}}</td>
                </tr>
                <tr>
                    <td>Kategori Kasus</td>
                    <td>:</td>
                    <td>{{$reporter->categories_type}}</td>
                </tr>
                <tr>
                    <td>Pelaku</td>
                    <td>:</td>
                    <td>{{$perpetratorsNames ?? '-'}}</td>
                </tr>
                <tr>
                    <td>Korban</td>
                    <td>:</td>
                    <td>{{$victimNames ?? '-'}}</td>
                </tr>
                <tr>
                    <td>Lokasi Kejadian</td>
                    <td>:</td>
                    <td>{{ $reporter?->reporterDetail?->location ?? 'Pelapor belum mengisi data.' }}</td>
                </tr>
                <tr>
                    <td>Waktu Kejadian</td>
                    <td>:</td>
                    <td>  {{ $reporter?->reporterDetail?->formatted_report_date ?? 'Pelapor belum mengisi data.' }}</td>
                </tr>
            </table>
            
            <div class="incident-description">
                <h4>Uraian Singkat Kejadian:</h4>
                <p>
                   {{$reporter->description ?? 'Pelapor belum mengisi uraian kejadian.'}}
                </p>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            TINDAKAN PENYELESAIAN
        </div>
        <div class="section-content">
            <div class="resolution-text">
                Berdasarkan investigasi dan evaluasi yang telah dilakukan, laporan ini telah diselesaikan dengan dikeluarkannya <strong>{{ $reporter?->operation?->name}}</strong> kepada pelaku yang bersangkutan.
            </div>
            <div class="resolution-text">
                Untuk mendukung pemulihan korban, telah diberikan <strong>dukungan dan pendampingan psikologis</strong> oleh konselor profesional. Tim monitoring akan melakukan pemantauan perilaku pelaku secara berkala untuk memastikan tidak terulangnya incident serupa dan memantau progress perkembangan sikap pelaku.
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            CATATAN PENYELESAIAN
        </div>
        <div class="section-content">
            
            <div class="evidence-list">
               <strong>{{ $reporter->reason ?? 'Tidak ada catatan tambahan dari pihak sekolah.' }}</strong>
            </div>
            
            <p class="note">
                <strong>Catatan:</strong> Seluruh detail lengkap, dokumentasi bukti, dan arsip terkait kasus ini tersimpan dengan aman dalam sistem arsip resmi institusi dan dapat diakses sewaktu-waktu untuk keperluan evaluasi atau tindak lanjut.
            </p>
        </div>
    </div>

</body>
</html>