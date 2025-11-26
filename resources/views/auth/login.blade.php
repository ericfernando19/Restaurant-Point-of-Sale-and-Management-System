<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS Restoran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* --- General Setup --- */
        body {
            --pos-primary: #17a2b8;
            /* Cyan/Info color for action */
            --pos-secondary: #f0f0f3;
            /* Light background */
            --pos-text: #343a40;
            /* Dark text */

            background-color: var(--pos-secondary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* --- Login Card Container --- */
        .login-container {
            width: 90%;
            max-width: 400px;
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            /* Soft lift shadow */
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-3px);
        }

        /* --- Header / Logo --- */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--pos-primary);
            margin-bottom: 5px;
        }

        .login-header p {
            color: #6c757d;
        }

        /* --- Input Fields --- */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--pos-text);
            font-size: 0.95rem;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border-color: var(--pos-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.2);
        }

        /* --- Checkbox & Links --- */
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }

        .remember-me label {
            font-weight: normal;
            color: var(--pos-text);
        }

        .forgot-link {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--pos-primary);
            text-decoration: underline;
        }

        /* --- Button --- */
        .login-button {
            width: 100%;
            padding: 15px;
            background-color: var(--pos-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.3s;
            margin-top: 30px;
        }

        .login-button:hover {
            background-color: #138496;
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
        }

        /* Session Status (Placeholder styling) */
        .session-status {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-utensils"></i> POS Restoran</h2>
            <p>Silakan masuk untuk melanjutkan transaksi</p>
        </div>

        @if (session('status'))
            <div class="session-status">
                {{ session('status') }}
            </div>
        @endif


        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username" />
                {{-- Error messages should be handled by the server/controller --}}
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input id="password" class="input-field" type="password" name="password" required
                    autocomplete="current-password" />
                {{-- Error messages should be handled by the server/controller --}}
            </div>

            <div class="options-row">
                <div class="remember-me">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <button class="login-button" type="submit">
                Log in
            </button>
        </form>
    </div>

</body>

</html>
