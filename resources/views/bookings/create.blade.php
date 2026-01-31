@extends('layouts.user')

@section('title', 'Book ' . $hall->name)

@section('content')
    @livewire('booking-component', ['hallId' => $hall->id])
@endsection
