@extends('layouts.master')
@section('content')

	<div class="row" style="margin-top: 40px;">
	@foreach($proximasCitas as $proximaCita)
      	<div class="col l4 s12">
		  <div class="card">
		    <div class="card-content">
		      <p><b>Se debe de agendar una cita.</b></p>
		    </div>
		    <div class="card-tabs">
		      <ul class="tabs tabs-fixed-width">
		        <li class="tab">Información del Cliente</li>
		      </ul>
		    </div>
		    <div class="card-content grey lighten-4">
		      <div id="proximaCita"><b>Nombre:</b> {{ $proximaCita->nombreCliente }} {{ $proximaCita->apellidoCliente }}</div>
		      <div id="proximaCita"><b>Telefono:</b> {{ $proximaCita->telCliente }}</div>
		      <div id="proximaCita"><b>Servicio realizado:</b> {{ $proximaCita->servicio }}</div>
		      <div id="proximaCita"><b>Fecha estimada para siguiente cita:</b> {{ $proximaCita->fechaSiguiente }}</div>
		      <div id="proximaCita"><b>Descripción del servicio:</b> {{ $proximaCita->descripcion }}</div>
		      {!! Form::open(['action' => ['ToDoController@update']]) !!}
		      	<input type="hidden" name="id" value="{{ $proximaCita->id }}">
			    <p>
	      		  	<label>
	      		  		@if($proximaCita->agendada == 1)
	        				<input name="agendada" type="checkbox" checked="checked"/>
	        			@else
	        				<input name="agendada" type="checkbox"/>
	        			@endif
	        			<span>Agendada</span>
	      			</label>
	    		</p>
		      	<p>
      		  		<label>
      		  			@if($proximaCita->finalizado == 1)
        					<input name="finalizado" type="checkbox" checked="checked"/>
	        			@else
	        				<input name="finalizado" type="checkbox"/>
	        			@endif
        				<span>Servicio terminado</span>
      				</label>
    			</p>
    			<div class="modal-footer">
					<center><button class="btn waves-effect waves-light" type="submit" name="action">Confirmar<i class="material-icons right">send</i></button></center>
				</div>
		      {!! Form::close() !!}
		    </div>
		  </div>
		</div>
	@endforeach
	</div>
@endsection()