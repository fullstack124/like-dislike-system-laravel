@extends('layouts.app')
@section('content')
    <div class="container mx-auto">
        <div>
            <a href="{{ route('auth.logout') }}" class="px-2 py-1 bg-red-600"  id="make_replay">Logout</a>
        </div>
        <div id="show_all_posts"></div>
    </div>
@endsection
