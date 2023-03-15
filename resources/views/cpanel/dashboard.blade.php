@extends('layout.default')
@section('title', 'Dashboard')
@section('content')
    @if (Auth::user()->isAdmin())
        @includeIf('cpanel.dashboard.admin', [])
    @elseif (Auth::user()->isMember())
        @includeIf('cpanel.dashboard.member', [])
    @elseif (Auth::user()->isPartner())
        @includeIf('cpanel.dashboard.partner', [])
    @endif
@endsection
