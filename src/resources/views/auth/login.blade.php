<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <header>
        <h1>ログイン</h1>
    </header>
    <main>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <button type="submit">ログイン</button>
        </form>
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </main>
</body>
</html>
