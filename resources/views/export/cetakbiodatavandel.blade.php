<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Biodata Vandel</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/yudisium-fewarmadewa.png') }}" />
  </head>

  <body style="font-family:Calibri; font-size:14px" onload="doPrint()">
    <H1 align="center">BIODATA VANDEL</H1>
    <div align="center" style="position:fixed; right:50px; top:25px;"><img src="{{ url('storage') . '/' . $data->foto_biodata }}" style="width:83px; height:113px"></div>
    <table width="100%" border="0" style="border-collapse:collapse; margin-top:10px">
      <tr>
        <td width="37%">NAMA LENGKAP</td>
        <td width="1%">:</td>
        <td width="62%">{{ $data->nama }}</td>
      </tr>
      <tr>
        <td>NPM</td>
        <td>:</td>
        <td>{{ $data->NPM }}</td>
      </tr>
      <tr>
        <td>PROGRAM STUDI</td>
        <td>:</td>
        <td>{{ $data->prodi }}</td>
      </tr>
      <tr>
        <td>JENIS KELAMIN</td>
        <td>:</td>
        <td>{{ $data->jenis_kelamin }}</td>
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
