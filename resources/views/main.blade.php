@extends('layouts.app')
@section('content')
<div class="container-fluid">
  @if (!Auth::guest())
  @foreach($users as $user)
  <ul>
    <li class="user liUser" id="{{ $user->id }}">
      <div class="media-body">

        <a class='liA_user' href="/chats/{{ $user->id }}">{{ $user->name }}</a>
      </div>
    </li>
  </ul>
  @endforeach
  @endif
  @if ($message = Session::get('success'))
  <div class="alert alert-success">
    <p>{{ $message }}</p>
  </div>
  @endif
</div>

@endsection