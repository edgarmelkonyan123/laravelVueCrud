@extends('layouts.app')

@section('content')

    <sections-form id="@if(!empty($section)){{$section->id}}@endif" error="@if(count($errors)>0){{true}}@else{{false}}@endif"></sections-form>

@endsection