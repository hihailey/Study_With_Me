@extends('layouts.app')
@section('content')

<dashboard username="{{ Auth::user()->name }}" userId="{{ Auth::user()->id }}"></dashboard>
@endsection
