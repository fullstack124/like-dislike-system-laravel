@extends('layouts.app')

@section('content')
    <div class="h-screen bg-indigo-100 flex justify-center items-center">
        <div class="lg:w-2/5 md:w-1/2 w-2/3">
            <form class="bg-white p-10 rounded-lg shadow-lg min-w-full" method="POST" action="{{ route('user.login') }}">
                @csrf
                <h1 class="text-center text-2xl mb-6 text-gray-600 font-bold font-sans">Login</h1>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="email">Email</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="email"
                        id="email" placeholder="@email" />
                        @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                </div>
                <div>
                    <label class="text-gray-800 font-semibold block my-3 text-md" for="password">Password</label>
                    <input class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="password" name="password"
                        id="password" placeholder="password" />
                        @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full mt-6 bg-indigo-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans">Login</button>
                <button type="button" onclick="window.location.href='{{ route('auth.register') }}'"
                    class="w-full mt-6 mb-3 bg-indigo-100 rounded-lg px-4 py-2 text-lg text-gray-800 tracking-wide font-semibold font-sans">Register</button>
            </form>
        </div>
    </div>
@endsection
