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
            <h2>{{ $user->name }}さんの勤怠</h2>

            <!-- 月選択フォーム -->
            <form action="{{ route('admin.attendance.staff', $user->id) }}" method="GET">
                <label for="month"></label>
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
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->clock_in ? $attendance->clock_in->format('Y-m-d') : '' }}</td>
                            <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '未設定' }}</td>
                            <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '未設定' }}</td>
                            <td>{{ $attendance->total_break_time }}</td>
                            <td>{{ $attendance->total_time }}</td>
                            <td>
                                <a href="{{ route('admin.attendance.show', $attendance->user_id) }}" class="btn btn-primary">詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <!-- CSV出力ボタン -->
    <form action="{{ route('admin.attendance.export_csv') }}" method="GET">
        <button type="submit">CSV出力</button>
    </form>
</body>
</html>
