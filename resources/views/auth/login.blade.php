<x-guest-layout>
    <x-auth-card class="vh-100 d-flex justify-content-center align-items-center">


        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form class="w-100" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="text-danger">
                @include('inc.messages')
                {{ session()->forget('msg') }}
            </div>

            <!-- Email Address -->
            <div>

                <x-input id="email" placeholder="{{ __('E-Mail Address') }}" class="form-control" type="email"
                    name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">

                <x-input id="password" class="block mt-1 w-full" placeholder="{{ __('Password') }}" type="password"
                    name="password" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    <a href="{{ url('/register') }}" class="btn btn-info ml-3">
                        {{ __('Register') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}

                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
