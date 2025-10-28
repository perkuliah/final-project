<div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <div class="logo-square"></div>
                </div>
                <h2>Log In Dulu Ya</h2>
                <p>Masukkan Email dan Password</p>
            </div>
            
            <form wire:submit.prevent="login" class="login-form" id="loginForm" novalidate>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" wire:model.defer="email" required autocomplete="email">
                    </div>
                    @error('email')
                        <span class="error-message" id="emailError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" wire:model.defer="password" required autocomplete="current-password">
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="toggle-text">SHOW</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message" id="passwordError">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember" wire:model="remember">
                        <label for="remember" class="checkbox-label">
                            <div class="checkbox-box"></div>
                            <span>Remember me</span>
                        </label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn" wire:loading.attr="disabled">
                    <span class="btn-text" wire:loading.remove>Log In</span>
                    <div class="btn-loader" wire:loading>
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                    </div>
                </button>
            </form>

            <div class="divider">
                <span>Atau</span>
            </div>

            <div class="signup-link">
                <span>Hubungi Admin Jika Tidak Bisa</span>
            </div>

            <div class="success-message" id="successMessage">
                <div class="success-icon">✓</div>
                <h3>Success</h3>
                <p>Redirecting...</p>
            </div>
        </div>
    </div>
</div>