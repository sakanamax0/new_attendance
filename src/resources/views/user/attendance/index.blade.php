<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠登録画面</title>
    <link rel="stylesheet" href="{{ asset('css/attend.css') }}">
</head>
<body>
    <header>
        <div class="header-container">
            <h1 class="logo">COACHTECH</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('attendance.index') }}">勤怠</a></li>
                    <li><a href="{{ route('attendance.list') }}">勤怠一覧</a></li>
                    <li><a href="{{ route('attendance.stamp_correction_request.list') }}">申請</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color:blue; cursor:pointer;">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="container">
            <!-- 勤怠ステータス表示 -->
            <span class="status-label">
                @if($attendance)
                    {{ $attendance->getStatusLabel() }}
                @else
                    勤務外
                @endif
            </span>

            <p class="date">
                {{ \Carbon\Carbon::now()->locale('ja_JP')->isoFormat('YYYY年M月D日(ddd)') }}
            </p>
            <p class="time">{{ now()->format('H:i') }}</p>

            @if ($attendance)
                @if ($attendance->status === \App\Enums\AttendanceStatus::OFF_DUTY)  <!-- 勤務外 -->
                    <form action="{{ route('attendance.checkIn') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">出勤</button>
                    </form>
                @elseif ($attendance->status === \App\Enums\AttendanceStatus::WORKING)  <!-- 勤務中 -->
                    <form action="{{ route('attendance.breakStart', $attendance->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">休憩開始</button>
                    </form>
                    <form action="{{ route('attendance.checkOut') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">退勤</button>
                    </form>
                @elseif ($attendance->status === \App\Enums\AttendanceStatus::BREAK)  <!-- 休憩中 -->
                    <form action="{{ route('attendance.breakEnd', $attendance->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">休憩終了</button>
                    </form>
                @endif
            @else
                <!-- 勤怠情報がない場合に勤務開始ボタンを表示 -->
                <form action="{{ route('attendance.checkIn') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">出勤</button>
                </form>
            @endif

            <!-- メッセージ表示 -->
            @if(isset($message) && $message)
                <p class="message">{{ $message }}</p>
            @endif
        </div>
    </main>
</body>
</html>
