@extends('layouts.app')
@section('content')

<div class="container-fluid">


    <dashboard username="{{ Auth::user()->name }}" userId="{{ Auth::user()->id }}"></dashboard>


</div>

@endsection