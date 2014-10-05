@extends('layouts.master')

@section('head')
	@parent
	<title>Home Page</title>
@stop

@section('content')
Home Page
	@if(Session::has('success'))
		<div class="alert alert-success"><p>{{ Session::get('success') }}</p></div>
	@elseif (Session::has('fail'))
		<div class="alert alert-danger"><p>{{ Session::get('fail') }}</p></div>
	@endif	

@stop