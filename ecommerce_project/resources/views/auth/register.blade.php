<x-guest-layout>
            <!-- Judul -->
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Sign Up</h2>

            <!-- Google Register Button -->
            <div class="mb-6">
                <a href="{{ route('auth.redirect', ['provider' => 'google']) }}" class="flex items-center justify-center w-full bg-red-600 text-white py-3 rounded-lg shadow hover:bg-red-700 transition duration-200">
                    <i class="bi bi-google text-lg mr-2"></i>
                    <span>Sign up with Google</span>
                </a>
            </div>

            <!-- Separator -->
            <div class="flex items-center justify-center mb-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="px-3 text-gray-500 text-sm font-medium">Or</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required autocomplete="new-password">
                    @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required autocomplete="new-password">
                    @error('password_confirmation')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                        Create Account
                    </button>
                </div>

                <!-- Already Registered -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">Log In</a>
                    </p>
                </div>
            </form>
</x-guest-layout>

