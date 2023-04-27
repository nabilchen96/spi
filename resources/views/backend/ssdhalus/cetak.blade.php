<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Pengujian Berat Isi Kasar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <h4 class="text-center">LAPORAN SEMENTARA <br> PEMERIKSAAN SSD HALUS </h4>
            <table class="table table-bordered">
                <tr>
                    <td colspan="4"><b>Benda Uji :</b></td>
                </tr>
                <tr>
                    <td>a. Pasir Asal</td>
                    <td>:</td>
                    <td colspan="2">{{ $data->pasir_asal }}</td>
                </tr>
               
                <tr>
                    <td colspan="4"><b>Hasil Pengujian :</b></td>
                </tr>
                <tr>
                    <td>a. Berat pasir + tabung ukur + air</td>
                    <td>:</td>
                    <td>{{ $data->berat_pasir_tabung_air }} gr</td>
                    <td>(A)</td>
                </tr>
                <tr>
                    <td>b. Berat pasir SSD</td>
                    <td>:</td>
                    <td>{{ $data->berat_pasir_ssd }} gr</td>
                    <td>(B)</td>
                </tr>
                <tr>
                    <td>c. Berat tabung ukur + air</td>
                    <td>: </td>
                    <td>{{ $data->berat_tabung_air }} gr</td>
                    <td>(C)</td>
                </tr>
                <tr>
                    <td>d. Berat pasir kering tungku</td>
                    <td>: </td>
                    <td>{{ $data->berat_pasir_kering_tungku }} gr</td>
                    <td>(D)</td>
                </tr>
               
                <tr>
                    <td colspan="4"><b>Kesimpulan : </b></td>
                </tr>
                <tr>
                    <td>a. Berat Jenis Tungku</td>
                    <td>D/((C+B)-A)</td>
                    <td>=</td>
                    <td>{{ number_format($data->berat_jenis_tungku,2) }}</td>
                </tr>
                <tr>
                    <td>b. SSD Pasir kering tungku</td>
                    <td>B/((C+B)-A)</td>
                    <td>=</td>
                    <td>{{  number_format($data->ssd_pasir_kering_tungku,2) }} </td>
                </tr>
                <tr>
                    <td colspan="4">b. Menurut berat jenis dan SSD pasir, benda uji <b>{{ $data->kesimpulan }}</b> syarat, untuk berat jenis pasir SSD yang baik adalah 2,4 - 2,9</td>
                </tr>
                
            </table>
        </div>
    </div>
</body>
</html>