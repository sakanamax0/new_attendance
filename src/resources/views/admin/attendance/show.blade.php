<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠詳細</title>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">COACHTECH</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.attendance.list') }}">勤怠一覧</a></li>
                    <li><a href="#">スタッフ一覧</a></li>
                    <li><a href="#">申請一覧</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>勤怠詳細</h2>

            <!-- 勤怠詳細の表示 -->
            <table class="attendance-table">
                <tr>
                    <th>名前</th>
                    <td>{{ $attendance->user->name }}</td>
                </tr>
                <tr>
                    <th>日付</th>
                    <td>{{ $attendance->clock_in ? $attendance->clock_in->format('Y年m月d日') : '' }}</td>
                </tr>
                <tr>
                    <th>出勤・退勤</th>
                    <td>
                        {{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '未設定' }} ～
                        {{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '未設定' }}
                    </td>
                </tr>
                <tr>
                    <th>休憩</th>
                    <td>
                        {{ optional($attendance->break_start_time)->format('H:i') ?: '未設定' }} ～
                        {{ optional($attendance->break_end_time)->format('H:i') ?: '未設定' }}
                    </td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>{{ $attendance->remarks ?? 'なし' }}</td>
                </tr>
            </table>

            <!-- 修正ボタン（編集ページへ遷移） -->
            <form action="{{ route('admin.attendance.detail', $attendance->id) }}" method="GET"> 
                <button type="submit" class="btn">修正</button>
            </form>
        </div>
    </main>
</body>
</html>
