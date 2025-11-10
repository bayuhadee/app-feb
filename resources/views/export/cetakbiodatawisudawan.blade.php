<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Biodata Wisudawan</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/yudisium-fewarmadewa.png') }}" />
  </head>

  <body style="font-family:Calibri; font-size:14px" onload="doPrint()">
    <table width="87%" border="0">
      <tr>
        <td><img src="{{ asset('assets/images/header.jpg') }}" width="692" height="130"></td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td align="center" style="font-size:16px"><strong>PANITIA</strong></td>
      </tr>
      <tr>
        <td align="center" style="border-bottom:#000 1px solid; font-size:16px"><strong>YUDISIUM DAN LEPAS PESAN CALON WISUDAWAN KE-79 TH {{ date('Y') }}</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-size:18px"><strong>BIODATA WISUDAWAN</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-size:18px"><strong>FAKULTAS EKONOMI UNWAR</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div align="center" style="position:fixed; right:0px; top:200px;"><img src="{{ url('storage') . '/' . $data->foto_biodata }}" style="width:143px; height:211px"></div>
    <table width="100%" border="0" style="border-collapse:collapse; margin-top:10px">
      <tr>
        <td width="37%">NAMA LENGKAP</td>
        <td width="1%">:</td>
        <td width="62%">{{ $data->nama }}</td>
      </tr>
      <tr>
        <td>TEMPAT/TGL. LAHIR</td>
        <td>:</td>
        <td>{{ $data->ttl }}</td>
      </tr>
      <tr>
        <td>NPM</td>
        <td>:</td>
        <td>{{ $data->NPM }}</td>
      </tr>
      <tr>
        <td>FAKULTAS</td>
        <td>:</td>
        <td>EKONOMI</td>
      </tr>
      <tr>
        <td>PROGRAM STUDI</td>
        <td>:</td>
        <td>{{ $data->prodi }}</td>
      </tr>
      <tr>
        <td>AGAMA</td>
        <td>:</td>
        <td>{{ $data->agama }}</td>
      </tr>
      <tr>
        <td>JENIS KELAMIN</td>
        <td>:</td>
        <td>{{ $data->jenis_kelamin }}</td>
      </tr>
      <tr>
        <td>ASAL</td>
        <td>:</td>
        <td>{{ $data->asal }}</td>
      </tr>
      <tr>
        <td>ALAMAT SEKARANG</td>
        <td>:</td>
        <td>{{ $data->alamat }}</td>
      </tr>
      <tr>
        <td>TELP./HP</td>
        <td>:</td>
        <td>{{ $data->nomor_hp }}</td>
      </tr>
      <tr>
        <td>NO WHATSAPP</td>
        <td>:</td>
        <td>{{ $data->nomor_wa }}</td>
      </tr>
      <tr>
        <td>EMAIL</td>
        <td>:</td>
        <td>{{ $data->email }}</td>
      </tr>
      <tr>
        <td>TGL. LULUS UJIAN SKRIPSI</td>
        <td>:</td>
        <td>{{ $data->tanggal_lulus }}</td>
      </tr>
      <tr>
        <td>INDEK PRESTASI (IP)</td>
        <td>:</td>
        <td>{{ $data->ipk }}</td>
      </tr>
      <tr>
        <td>PREDIKAT KELULUSAN</td>
        <td>:</td>
        <td>{{ $data->predikat_lulus }}</td>
      </tr>
      <tr>
        <td valign="top">JUDUL SKRIPSI</td>
        <td valign="top">:</td>
        <td>{{ $data->judul }}</td>
      </tr>
      <tr>
        <td>NAMA ORANG TUA/WALI</td>
        <td>:</td>
        <td>{{ $data->nama_orangtua }}</td>
      </tr>
      <tr>
        <td>PEKERJAAN WISUDAWAN</td>
        <td>:</td>
        <td>{{ $data->pekerjaan ?? '' }}</td>
      </tr>
      <tr>
        <td>NAMA KANTOR/PERUSAHAAN</td>
        <td>:</td>
        <td>{{ $data->nama_kantor ?? '' }}</td>
      </tr>
      <tr>
        <td>ALAMAT KANTOR/PERUSAHAAN</td>
        <td>:</td>
        <td>{{ $data->alamat_kantor ?? '' }}</td>
      </tr>
      <tr>
        <td>TELP/HP</td>
        <td>:</td>
        <td>{{ $data->telp_kantor ?? '' }}</td>
      </tr>
      <tr>
        <td>TAMBAHAN KETERAMPILAN</td>
        <td>:</td>
        <td>{{ $data->tambahan_keterampilan ?? '' }}</td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </body>

</html>
<script>
  function doPrint() {
    window.print();
    //window.close();
  }
</script>
