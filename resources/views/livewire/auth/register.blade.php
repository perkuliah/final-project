<div>
    <style>
        /* Modern Brutalist Login Form - Complete & Self-Contained */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .bodys {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px; /* Lebih kecil di mobile */
            line-height: 1.4;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: #ffffff;
            border: 3px solid #000000;
            border-radius: 0;
            padding: 32px; /* Lebih kecil di mobile default */
            box-shadow: 6px 6px 0 #000000;
            transition: all 0.2s ease;
        }

        .login-card:hover {
            transform: translate(-2px, -2px);
            box-shadow: 8px 8px 0 #000000;
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo {
            margin-bottom: 12px;
            display: flex;
            justify-content: center;
        }

        .logo-square {
            width: 40px;
            height: 40px;
            background: #000000;
            border: 3px solid #000000;
            position: relative;
        }

        .logo-square::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 14px;
            height: 14px;
            background: #ffffff;
        }

        .login-header h2 {
            color: #000000;
            font-size: 1.5rem; /* Lebih kecil di mobile */
            font-weight: 900;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-header p {
            color: #666666;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            border: 2px solid #000000;
            background: #ffffff;
        }

        .input-wrapper input,
        .input-wrapper select {
            width: 100%;
            background: transparent;
            border: none;
            padding: 12px 16px;
            color: #000000;
            font-size: 16px;
            font-weight: 500;
            outline: none;
            font-family: inherit;
        }

        .input-wrapper input::placeholder {
            color: #999999;
        }

        .input-wrapper:focus-within {
            box-shadow: 4px 4px 0 #000000;
            transform: translate(-2px, -2px);
        }

        /* Password Toggle */
        .password-wrapper {
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            flex: 1;
            padding-right: 60px;
        }

        .password-toggle {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            background: #000000;
            color: #ffffff;
            border: none;
            padding: 0 10px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .password-toggle:hover {
            background: #333333;
        }

        .password-toggle:active {
            transform: scale(0.98);
        }

        /* Form Options & Role Select */
        .brutalist-select {
            width: 100%;
            background: transparent;
            border: none;
            padding: 12px 16px;
            color: #000000;
            font-size: 16px;
            font-weight: 500;
            font-family: 'Arial', sans-serif;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 14px;
            cursor: pointer;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            background: #000000;
            color: #ffffff;
            border: 2px solid #000000;
            padding: 14px;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            margin-bottom: 20px;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .login-btn:hover {
            background: #333333;
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0 #000000;
        }

        .login-btn:active {
            transform: translate(0, 0);
            box-shadow: 2px 2px 0 #000000;
        }

        .btn-text {
            position: relative;
            z-index: 1;
        }

        .btn-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            gap: 3px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .loader-bar {
            width: 3px;
            height: 16px;
            background: #ffffff;
            animation: loaderPulse 1s ease-in-out infinite;
        }

        .loader-bar:nth-child(2) { animation-delay: 0.2s; }
        .loader-bar:nth-child(3) { animation-delay: 0.4s; }

        @keyframes loaderPulse {
            0%, 80%, 100% { transform: scaleY(0.5); opacity: 0.5; }
            40% { transform: scaleY(1); opacity: 1; }
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            height: 1px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #000000;
            transform: translateY(-50%);
        }

        /* Error & Success */
        .error-message {
            color: #dc3545;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
            margin-left: 2px;
            display: block;
            opacity: 1;
            transform: none;
        }

        .success-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .success-message.show {
            opacity: 1;
            pointer-events: all;
        }

        .success-icon {
            width: 48px;
            height: 48px;
            background: #000000;
            color: #ffffff;
            border: 2px solid #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            margin-bottom: 16px;
            animation: successPop 0.5s ease-out;
        }

        @keyframes successPop {
            0% { transform: scale(0); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .success-message h3 {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        /* === Enhanced Mobile Responsiveness === */
        @media (max-width: 480px) {
            .bodys {
                padding: 12px;
            }

            .login-card {
                padding: 24px;
                box-shadow: 5px 5px 0 #000000;
            }

            .login-card:hover {
                transform: translate(-1px, -1px);
                box-shadow: 6px 6px 0 #000000;
            }

            .logo-square {
                width: 36px;
                height: 36px;
            }

            .logo-square::after {
                width: 12px;
                height: 12px;
            }

            .login-header h2 {
                font-size: 1.35rem;
            }

            .form-label {
                font-size: 10px;
            }

            .password-toggle {
                padding: 0 8px;
                font-size: 9px;
            }

            .login-btn {
                padding: 12px;
                font-size: 13px;
            }

            .brutalist-select {
                padding: 12px 14px;
                background-position: right 12px center;
                background-size: 12px;
            }
        }
    </style>

    <div class="bodys">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo">
                        <div class="logo-square"></div>
                    </div>
                    <h2>Daftarkan Anggotamu</h2>
                    <p>Buat email dan password</p>
                </div>

                <form wire:submit.prevent="register" class="login-form" novalidate>
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" id="name" wire:model.defer="name" required autocomplete="name">
                        </div>
                        @error('name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" wire:model.defer="email" required autocomplete="email">
                        </div>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper password-wrapper">
                            <input type="password" id="password" wire:model.defer="password" required autocomplete="new-password">
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                                <span class="toggle-text">SHOW</span>
                            </button>
                        </div>
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-wrapper password-wrapper">
                            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" required autocomplete="new-password">
                            <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                                <span class="toggle-text">SHOW</span>
                            </button>
                        </div>
                        @error('password_confirmation') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="input-wrapper">
                            <select wire:model="role" class="brutalist-select">
                                <option value="">Pilih Role</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        @error('role') 
                            <small class="error-message">{{ $message }}</small> 
                        @enderror
                    </div>

                    <button type="submit" class="login-btn" wire:loading.attr="disabled">
                        <span class="btn-text" wire:loading.remove>SIGN UP</span>
                        <div class="btn-loader" wire:loading>
                            <div class="loader-bar"></div>
                            <div class="loader-bar"></div>
                            <div class="loader-bar"></div>
                        </div>
                    </button>
                </form>

                <div class="divider"></div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="success-message show">
            <div class="success-icon">✓</div>
            <h3>{{ session('success') }}</h3>
        </div>
    @endif
</div>