<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចូលប្រើប្រព័ន្ធ</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Kantumruy Pro', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-logo .icon {
            width: 70px; height: 70px;
            background: rgba(255,255,255,.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: .75rem;
            backdrop-filter: blur(10px);
        }
        .login-logo h1 { color: #fff; font-size: 1.4rem; font-weight: 700; }
        .login-logo p  { color: rgba(255,255,255,.75); font-size: .85rem; margin-top: .25rem; }

        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }

        .form-group { margin-bottom: 1.2rem; }
        label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .4rem;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #9CA3AF;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .7rem .9rem .7rem 2.5rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 8px;
            font-size: .92rem;
            font-family: inherit;
            color: #1F2937;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input:focus {
            border-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        }
        input.is-invalid { border-color: #EF4444; }

        .error-msg { color: #EF4444; font-size: .8rem; margin-top: .35rem; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.4rem;
            font-size: .85rem;
            color: #6B7280;
        }
        .remember-row input[type="checkbox"] { accent-color: #6366F1; width: 16px; height: 16px; }

        .btn-login {
            width: 100%;
            padding: .8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
        }
        .btn-login:hover  { opacity: .92; }
        .btn-login:active { transform: scale(.98); }

        .demo-accounts {
            margin-top: 1.5rem;
            background: #F9FAFB;
            border-radius: 10px;
            padding: 1rem;
        }
        .demo-title { font-size: .8rem; font-weight: 600; color: #6B7280; margin-bottom: .6rem; text-align: center; text-transform: uppercase; letter-spacing: .05em; }
        .demo-list  { display: flex; flex-direction: column; gap: .5rem; }
        .demo-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 7px;
            padding: .5rem .75rem;
            cursor: pointer;
            transition: border-color .2s;
            font-size: .82rem;
        }
        .demo-item:hover { border-color: #6366F1; }
        .demo-role {
            padding: .15rem .55rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
        }
        .role-admin  { background: #FEE2E2; color: #B91C1C; }
        .role-leader { background: #FEF3C7; color: #92400E; }
        .role-staff  { background: #D1FAE5; color: #065F46; }
        .demo-email  { color: #374151; }
        .demo-hint   { color: #9CA3AF; font-size: .75rem; }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-logo">
        <div class="icon">🏢</div>
        <h1>ប្រព័ន្ធគ្រប់គ្រង</h1>
        <p>Multi-Role Management System</p>
    </div>

    <div class="login-card">
        <div class="form-group">
            <h2 style="font-size:1.2rem; font-weight:700; color:#1F2937; margin-bottom:.3rem;">ចូលប្រើប្រព័ន្ធ</h2>
            <p style="font-size:.83rem; color:#6B7280;">សូមបញ្ចូលអ៊ីមែល និង លេខសំងាត់របស់អ្នក</p>
        </div>

        @if ($errors->any())
            <div style="background:#FEE2E2; border-left:4px solid #EF4444; border-radius:8px; padding:.75rem 1rem; margin-bottom:1rem; font-size:.85rem; color:#7F1D1D;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">អ៊ីមែល</label>
                <div class="input-wrap">
                    <span class="input-icon">📧</span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="example@gmail.com"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">លេខសំងាត់</label>
                <div class="input-wrap">
                    <span class="input-icon">🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required
                    >
                </div>
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin:0; font-weight:400;">ចងចាំខ្ញុំ</label>
            </div>

            <button type="submit" class="btn-login">🔑 ចូលប្រើប្រព័ន្ធ</button>
        </form>

        <!-- Demo Accounts -->
        <div class="demo-accounts">
            <p class="demo-title">🧪 គណនីសាកល្បង</p>
            <div class="demo-list">
                <div class="demo-item" onclick="fillLogin('admin@example.com')">
                    <span class="demo-role role-admin">Admin</span>
                    <span class="demo-email">admin@example.com</span>
                    <span class="demo-hint">ចុចដើម្បីបំពេញ</span>
                </div>
                <div class="demo-item" onclick="fillLogin('leader@example.com')">
                    <span class="demo-role role-leader">Leader</span>
                    <span class="demo-email">leader@example.com</span>
                    <span class="demo-hint">ចុចដើម្បីបំពេញ</span>
                </div>
                <div class="demo-item" onclick="fillLogin('staff@example.com')">
                    <span class="demo-role role-staff">Staff</span>
                    <span class="demo-email">staff@example.com</span>
                    <span class="demo-hint">ចុចដើម្បីបំពេញ</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillLogin(email) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = 'password';
}
</script>
</body>
</html>
