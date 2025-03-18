<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ別勤怠一覧</title>
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">COACHTECH</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.attendance.list') }}">勤怠一覧</a></li>
                    <li><a href="{{ route('admin.staff.list') }}">スタッフ一覧</a></li>
                    <li><a href="#">申請一覧</a></li>
                    <li><a href="{{ route('logout') }}">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>{{ $staff->name }}さんの勤怠</h2>

            <!-- 月選択フォーム -->
            <form action="{{ route('admin.attendance.staff', $staff->id) }}" method="GET">
                <label for="month">月</label>
                <input type="month" name="month" value="{{ $month ?? now()->format('Y-m') }}">
                <button type="submit">検索</button>
            </form>

            <!-- 勤怠データの表示 -->
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>出勤</th>
                        <th>退勤</th>
                        <th>休憩</th>
                        <th>合計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->clock_in ? $attendance->clock_in->format('Y-m-d') : '' }}</td>
                            <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '未設定' }}</td>
                            <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '未設定' }}</td>
                            <td>
                                @if ($attendance->break_start_time && $attendance->break_end_time)
                                    {{ $attendance->break_start_time->diffInMinutes($attendance->break_end_time) }} 分
                                @else
                                    未設定
                                @endif
                            </td>
                            <td>{{ $attendance->total_working_hours ?? '未計算' }} 時間</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
