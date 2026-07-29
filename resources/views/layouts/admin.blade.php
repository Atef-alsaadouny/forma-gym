@extends('layouts.auth')

@section('title', $title ?? __('Dashboard'))

@section('header', $header ?? __('Dashboard'))

@section('content')
    @yield('admin-content')
@endsection
