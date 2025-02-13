<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>
    <div class="form-container">
        <h1>管理者ログイン</h1>
        <form method="POST" action="{{ url('/admin/login') }}">
            @csrf
            <div>
                <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="password" name="password" placeholder="パスワード">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <button type="submit">管理者ログインする</button>
            </div>
            @error('login')
                <div class="error">{{ $message }}</div>
            @enderror
        </form>
    </div>
</body>
</html>
