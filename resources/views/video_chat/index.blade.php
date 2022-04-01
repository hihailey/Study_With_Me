@extends('layouts.app')
@section('content')
<video-chat :user="{{ $user }}" :others="{{ $others }}" :usersInRoom="{{ $usersInRoom}}" pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></video-chat>
@endsection