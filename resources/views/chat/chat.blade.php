@extends('layouts.app')
@section('content')
<div class="container">
  @foreach($r as $r)
  <h1>{{ $r->name }}</h1>
  </form>
  @endforeach
  @foreach($g as $g)
  <form action="{{ url('/delete',$g->id) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
  </form>
  @endforeach

  <chat-component :user="{{ auth()->user() }}"></chat-component>


  <video-chat :user="{{ auth()->user() }}" pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></video-chat>

</div>
@endsection