<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
</head>
<body>
    <header>
        <h1>COACHTECH</h1>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </header>
    <main>
        <h2>会員登録</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label for="name">名前</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation">パスワード確認</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit">登録する</button>
        </form>
        <p><a href="/login">ログインはこちら</a></p>
    </main>
</body>
</html>
