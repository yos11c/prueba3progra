@extends('layouts.master')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Necesario para usar ajax -->
@endsection

@section('content')
	@if(count($errors) > 0)
		<div style="background-color: #f15858; border-radius: 4px; border: 1px solid #de3c3c; color: #FFF; font-family: 'Roboto'; margin-top: 10px; padding: 0px 10px;">
			<ul>
				@foreach ($errors->all() as $error)
					<ul>
						<li>• {{ $error }}</li>
					</ul>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="row">
		<div class="col l7 s12">
			<h2 style="text-align: center;margin-top: 5px;">Historial</h2>
		</div>
	</div>
	<table id="table_historial" class="display striped responsive-table">
		<thead>
			<th>Usuario</th>
			<th>Rol</th>
			<th>Acción</th>
			<th>Tabla</th>
			<th>Objeto</th>
			<th>Fecha</th>
		</thead>
		<tbody>
			@foreach($historias as $historia)
				<tr>
					<td>{{ $historia->user }}</td>
					<td>{{ $historia->rol }}</td>
					<td>{{ $historia->accion }}</td>
					<td>{{ $historia->tabla }}</td>
					<td>{{ $historia->objeto }}</td>
					<td>{{ $historia->created_at }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

@section('footer')
	<script type="text/javascript">
        $(document).ready(function() {
            $('#table_historial').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection
