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
		<h5>{{$result['judul']}}</h5>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Level Admin</th>
                <th>No. Telp</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			@php $i= 1 @endphp
            @foreach ($result['users'] as $users )
                <tr>
                    <td >{{$i++}}</td>
                    <td>{{ $users->name}}</td>
                    <td>{{ $users->role_nama}}</td>
                    <td>{{ $users->telp}}</td>
                    <td>{{ $users->email}}</td>
                </tr>
            @endforeach
		</tbody>
	</table>

</body>
</html>