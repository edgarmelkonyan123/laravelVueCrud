@extends('layouts.app')

@section('content')

    <users-form id="@if(!empty($user)){{$user->id}}@endif" error="@if(count($errors)>0){{true}}@else{{false}}@endif"></users-form>

@endsection