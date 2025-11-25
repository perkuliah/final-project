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
                            wire:model="email"
                            wire:keydown="resetVerificationMessage"
                            required
                            autocomplete="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email Anda"
                        >
                    </div>
                    @error('email')
                        <span class="error-message text-red-500 text-sm mt-1 block" id="emailError">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="input-wrapper password-wrapper relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            wire:model="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 pr-20 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('password') border-red-500 @enderror"
                        >
                        <button
                            type="button"
                            class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-sm font-medium text-blue-600 hover:text-blue-700"
                            id="passwordToggle"
                            aria-label="Toggle password visibility"
                        >
                            <span class="toggle-text">SHOW</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message text-red-500 text-sm mt-1 block" id="passwordError">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        </span>
                    @enderror
                </div>

                <div class="form-options flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="checkbox-wrapper flex items-center">
                        <input type="checkbox" id="remember" name="remember" wire:model="remember" class="sr-only">
                        <label for="remember" class="checkbox-label flex items-center cursor-pointer">
                            <div class="checkbox-box w-5 h-5 mr-2 flex items-center justify-center border-2 border-gray-400 rounded @if($remember) bg-blue-600 border-blue-600 @endif">
                                @if($remember)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm text-gray-700">Remember me</span>
                        </label>
                    </div>
                    <a href="#" class="forgot-link text-sm font-medium text-blue-600 hover:underline">Forgot password?</a>
                </div>

                <!-- Informasi Verifikasi Email (Hanya tampil saat diperlukan) -->
                @if($showVerificationMessage)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 animate-fade-in">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-yellow-800 font-medium">Email belum diverifikasi</p>
                            <p class="text-xs text-yellow-700 mt-1">
                                Email <span class="font-medium">{{ $email }}</span> belum diverifikasi.
                                Silakan hubungi admin untuk verifikasi email.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <button
                    type="submit"
                    class="login-btn w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                    wire:target="login"
                >
                    <span class="btn-text" wire:loading.remove wire:target="login">Log In</span>
                    <div class="btn-loader flex space-x-1" wire:loading wire:target="login">
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
                <span class="text-gray-600 text-sm">Hubungi Admin Jika Tidak Bisa Login</span>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- JavaScript untuk toggle password visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const passwordToggle = document.getElementById('passwordToggle');
            const passwordInput = document.getElementById('password');

            if (passwordToggle && passwordInput) {
                const toggleText = passwordToggle.querySelector('.toggle-text');

                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    toggleText.textContent = type === 'password' ? 'SHOW' : 'HIDE';
                });
            }

            // Auto-hide verification message when typing
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    // Pesan akan direset melalui Livewire method
                });
            }
        });

        // Fallback: Reset verification message on any key press in email field
        document.addEventListener('keydown', function(e) {
            if (e.target.id === 'email') {
                // Livewire akan menangani reset melalui method resetVerificationMessage
            }
        });
    </script>
</div>
