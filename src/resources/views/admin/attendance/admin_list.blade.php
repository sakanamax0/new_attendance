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
    </header>

    <main>
        <h1>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}の勤怠</h1>

        <div class="date-navigation">
            <form method="GET" action="{{ route('admin.attendance.admin_list') }}">
                <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($date)->subDay()->toDateString() }}">
                <button type="submit">← 前日</button>
            </form>

            <div class="date-display">
                <input type="text" value="{{ \Carbon\Carbon::parse($date)->format('Y/m/d') }}" readonly>
            </div>

            <form method="GET" action="{{ route('admin.attendance.admin_list') }}">
                <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($date)->addDay()->toDateString() }}">
                <button type="submit">翌日 →</button>
            </form>
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
                        <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '--:--' }}</td>
                        <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '--:--' }}</td>
                        <td>
                            @php
                                // 休憩時間の合計計算
                                $totalBreakMinutes = $attendance->breaktimes->reduce(function ($carry, $break) {
                                    $breakStart = \Carbon\Carbon::parse($break->break_start_time);
                                    $breakEnd = \Carbon\Carbon::parse($break->break_end_time);
                                    return $carry + $breakEnd->diffInMinutes($breakStart);
                                }, 0);
                            @endphp
                            {{ floor($totalBreakMinutes / 60) }}時間 {{ $totalBreakMinutes % 60 }}分
                        </td>
                        <td>
                            @if ($attendance->clock_in && $attendance->clock_out)
                                @php
                                    // 勤務時間（休憩時間を引いた実労働時間）
                                    $workMinutes = \Carbon\Carbon::parse($attendance->clock_out)->diffInMinutes(\Carbon\Carbon::parse($attendance->clock_in));
                                    $actualWorkMinutes = max(0, $workMinutes - $totalBreakMinutes);
                                @endphp
                                {{ floor($actualWorkMinutes / 60) }}時間 {{ $actualWorkMinutes % 60 }}分
                            @else
                                --:--
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.attendance.show', ['user_id' => $attendance->user_id]) }}" class="btn btn-primary">詳細</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
