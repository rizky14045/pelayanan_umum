<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Permohonan Konsumsi</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd;padding:25px;text-align:center;">
                            <h2 style="margin:0;color:#ffffff;">
                                🍽️ Pemberitahuan Permohonan Konsumsi
                            </h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">

                            <p style="font-size:15px;color:#444;margin-top:0;">
                                Yth. <strong>Bapak/Ibu</strong>,
                            </p>

                            <p style="font-size:15px;color:#555;line-height:24px;">
                                Telah diajukan <strong>permohonan konsumsi baru</strong>.
                                Berikut informasi permohonan yang memerlukan tindak lanjut:
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin-top:20px;">

                                <tr style="background:#f8f9fa;">
                                    <th align="left" width="35%" style="border:1px solid #dee2e6;">No. Pemesanan
                                        Ruangan</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['no_pemesanan'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #dee2e6;">Nama Acara</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['nama_acara'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <th align="left" style="border:1px solid #dee2e6;">Ruangan</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['ruangan'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #dee2e6;">Tanggal Acara</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['tanggal'] }}
                                        s/d
                                        {{ $surat['tanggal_selesai'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <th align="left" style="border:1px solid #dee2e6;">Jumlah Peserta</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['jumlah_peserta'] }} Orang
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #dee2e6;">Jumlah Konsumsi</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['jumlah_konsumsi'] }} Porsi
                                    </td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <th align="left" style="border:1px solid #dee2e6;">Jenis Konsumsi</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['jenis_konsumsi'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th align="left" style="border:1px solid #dee2e6;">Sumber Dana</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['sumber_dana'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <th align="left" style="border:1px solid #dee2e6;">Pemohon</th>
                                    <td style="border:1px solid #dee2e6;">
                                        {{ $surat['pemohon'] }}
                                    </td>
                                </tr>

                                @if (!empty($surat['keterangan']))
                                    <tr>
                                        <th align="left" style="border:1px solid #dee2e6;">Keterangan</th>
                                        <td style="border:1px solid #dee2e6;">
                                            {{ $surat['keterangan'] }}
                                        </td>
                                    </tr>
                                @endif

                                <tr style="background:#f8f9fa;">
                                    <th align="left" style="border:1px solid #dee2e6;">Status</th>
                                    <td style="border:1px solid #dee2e6;">
                                        <span
                                            style="display:inline-block;background:#ffc107;color:#000;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:bold;">
                                            Menunggu Persetujuan
                                        </span>
                                    </td>
                                </tr>

                            </table>

                            <div
                                style="margin-top:25px;padding:16px;background:#fff8e1;border-left:5px solid #ffc107;font-size:14px;color:#856404;line-height:22px;">
                                <strong>Informasi</strong><br>
                                Mohon untuk melakukan pengecekan dan memberikan persetujuan terhadap permohonan konsumsi
                                ini melalui aplikasi.
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8f9fa;padding:20px;text-align:center;font-size:13px;color:#777;">
                            Email ini dikirim secara otomatis oleh
                            <strong>Sistem Pelayanan Umum</strong>.<br>
                            Mohon untuk tidak membalas email ini.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
