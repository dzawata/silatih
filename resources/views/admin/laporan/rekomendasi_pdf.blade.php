<!DOCTYPE html>
<html>
<head>
	<title>{{$result['judul']}}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h4>{{$result['judul']}}</h4>
        <h5></h5>
	</center>

	
    <table class='table table-bordered'>
		<thead>
            <tr>
                <th class="text-center p-1 align-middle bg-light">#</th>
                <th class="text-center p-1 align-middle bg-light">NIK/Nama/Alamat</th>
                <th class="text-center p-1 align-middle bg-light">Jenis Kelamin</th>
                <th class="text-center p-1 align-middle bg-light">Pendidikan</th>
                <th class="text-center p-1 align-middle bg-light">Jurusan</th>
                <th class="text-center p-1 align-middle bg-light">Status Pekerjaan</th> 
                <th class="text-center p-1 align-middle bg-light">Rekomendasi Pelatihan</th>
            </tr>
        </thead>
		<tbody>
			@php $i= 1 @endphp
            @foreach ($rekomendasidata as $record )
            <tr>
                <td class="p-1">{{$i++}}</td>
                <td class="p-1">{{ $record->nik }}<br>
                                            <b>{{ $record->nama }}</b><br>
                                            {{ $record->alamat }}
                </td>
                <td>{{ $record->jenis_kelamin }}</td>
                                            <td>{{ $record->tingkat }}</td>
                                            <td>{{ $record->jurusan }}</td>
                                            <td>{{ $record->kelompok }}</td>
                                            <td bgcolor="#ffd4b8">{{ $record->rekomendasi }}</td>

            @endforeach
		</tbody>
	</table>


</body>
</html>