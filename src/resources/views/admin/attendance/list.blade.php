<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠一覧</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <header>
        <div class="logo">COACHTECH</div>
        <nav>
            <ul>
                <li><a href="#">勤怠一覧</a></li>
                <li><a href="#">スタッフ一覧</a></li>
                <li><a href="#">申請一覧</a></li>
                <li><a href="#">ログアウト</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}の勤怠</h1>

        <div class="date-navigation">
            <form method="GET" action="{{ route('admin.attendance.list') }}">
                <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}">
                <button type="submit">← 前日</button>
            </form>

            <div class="date-display">
                <input type="text" value="{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}" readonly>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>名前</th>
                    <th>出勤</th>
                    <th>退勤</th>
                    <th>休憩</th>
                    <th>合計</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->user->name }}</td>
                        <td>{{ $attendance->clock_in ?? '--:--' }}</td>
                        <td>{{ $attendance->clock_out ?? '--:--' }}</td>
                        <td>{{ $attendance->break_time ?? '0:00' }}</td>
                        <td>{{ $attendance->total_time ?? '0:00' }}</td>
                        <td><a href="#" class="detail-button">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
