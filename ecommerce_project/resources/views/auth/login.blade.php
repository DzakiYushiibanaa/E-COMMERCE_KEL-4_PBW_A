<x-guest-layout>
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">User Login</h2>
            <hr class="mb-4">

            <!-- Google Login Button -->
            <div class="mb-6">
                <a href="{{ route('auth.redirect', ['provider' => 'google']) }}" class="flex items-center justify-center w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition duration-200">
                    <i class="bi bi-google text-lg mr-2"></i> 
                    <span>Sign in with Google</span>
                </a>
            </div>

            <!-- Separator -->
            <div class="flex items-center justify-center mb-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="px-3 text-gray-500 text-sm font-medium">Or</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="email" name="email" type="text" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Forgot Password -->
                <div class="mb-4">
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-200">
                        LOGIN
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Sign Up</a>
                    </p>
                </div>
            </form>
</x-guest-layout>

