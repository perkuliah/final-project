<div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
    <div class="login-container w-full max-w-md">
        <div class="login-card bg-white rounded-xl shadow-lg p-6 sm:p-8 w-full">
            <div class="login-header text-center mb-6">
                <div class="logo flex justify-center mb-4">
                    <div class="logo-square w-12 h-12 bg-blue-600 rounded-md"></div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Log In Dulu Ya</h2>
                <p class="text-gray-600 mt-1">Masukkan Email dan Password</p>
            </div>

            <form wire:submit.prevent="login" class="login-form space-y-5" id="loginForm" novalidate>
                <div class="form-group">
                    <label for="email" class="form-label block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="input-wrapper">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            wire:model.defer="email"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                    </div>
                    @error('email')
                        <span class="error-message text-red-500 text-sm mt-1 block" id="emailError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="input-wrapper password-wrapper relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            wire:model.defer="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 pr-20 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        >
                        <button
                            type="button"
                            class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-sm font-medium text-blue-600"
                            id="passwordToggle"
                            aria-label="Toggle password visibility"
                        >
                            <span class="toggle-text">SHOW</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message text-red-500 text-sm mt-1 block" id="passwordError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="checkbox-wrapper flex items-center">
                        <input type="checkbox" id="remember" name="remember" wire:model="remember" class="sr-only">
                        <label for="remember" class="checkbox-label flex items-center cursor-pointer">
                            <div class="checkbox-box w-5 h-5 mr-2 flex items-center justify-center border-2 border-gray-400 rounded">
                                @if($remember)
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm text-gray-700">Remember me</span>
                        </label>
                    </div>
                    <a href="#" class="forgot-link text-sm font-medium text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <button
                    type="submit"
                    class="login-btn w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                    wire:loading.attr="disabled"
                >
                    <span class="btn-text" wire:loading.remove>Log In</span>
                    <div class="btn-loader flex space-x-1" wire:loading>
                        <div class="loader-bar w-2 h-2 bg-white rounded-full animate-bounce"></div>
                        <div class="loader-bar w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="loader-bar w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </button>
            </form>

            <div class="divider my-6 flex items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-gray-500 text-sm">Atau</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <div class="signup-link text-center">
                <span class="text-gray-600 text-sm">Hubungi Admin Jika Tidak Bisa</span>
            </div>

            <!-- Optional: success-message bisa disembunyikan secara default -->
            <div class="success-message hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" id="successMessage">
                <div class="bg-white p-6 rounded-lg text-center">
                    <div class="success-icon text-green-500 text-3xl mb-2">✓</div>
                    <h3 class="text-xl font-bold text-gray-800">Success</h3>
                    <p class="text-gray-600">Redirecting...</p>
                </div>
            </div>
        </div>
    </div>
</div>