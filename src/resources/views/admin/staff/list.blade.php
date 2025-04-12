<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ一覧</title>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">COACHTECH</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.attendance.admin_list') }}">勤怠一覧</a></li>
                    <li><a href="{{ route('admin.staff.list') }}">スタッフ一覧</a></li>
                    <li><a href="{{ route('admin.stamp_correction_request.list') }}">申請一覧</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                    @csrf
                        <button type="submit" class="btn btn-link">ログアウト</button>
                    </form>
                </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>スタッフ一覧</h2>
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>月次勤怠</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($staffs) > 0)
                        @foreach ($staffs as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a href="{{ route('admin.attendance.staff', $user->id) }}" class="btn">詳細</a></td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">スタッフが登録されていません</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
