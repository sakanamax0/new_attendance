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
                <li><a href="{{ route('attendance.index') }}">勤怠</a></li>
                <li><a href="{{ route('attendance.list') }}">勤怠一覧</a></li>
                <li><a href="#">申請</a></li>
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
        <h2 class="title">勤怠詳細</h2>

        <form action="{{ url('attendance/'.$attendance->id.'/update') }}" method="POST">

            @csrf
            @method('PUT')

            <table class="attendance-table">
                <tr>
                    <th>名前</th>
                    <td>{{ $attendance->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>日付</th>
                    <td>{{ $attendance->clock_in ? $attendance->clock_in->format('Y年 m月d日') : '-' }}</td>
                </tr>
                <tr>
                    <th>出勤時間</th>
                    <td><input type="time" name="clock_in" value="{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '' }}"></td>
                </tr>
                <tr>
                    <th>退勤時間</th>
                    <td><input type="time" name="clock_out" value="{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '' }}"></td>
                </tr>
                <tr>
                    <th>休憩開始</th>
                    <td><input type="time" name="break_start_time" value="{{ $attendance->break_start_time ? $attendance->break_start_time->format('H:i') : '' }}"></td>
                </tr>
                <tr>
                    <th>休憩終了</th>
                    <td><input type="time" name="break_end_time" value="{{ $attendance->break_end_time ? $attendance->break_end_time->format('H:i') : '' }}"></td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td><textarea name="remarks">{{ $attendance->remarks ?? '' }}</textarea></td>
                </tr>
            </table>

            {{-- 修正ボタン（管理者以外 & 修正可能な場合のみ） --}}
            @if ($attendance->is_locked == 1)
              <p class="text-danger">※承認待ちのため修正はできません。</p>
            @else
              <button type="submit" class="btn btn-primary">修正を申請</button>
            @endif
        </form>

        {{-- ✅ 管理者用の承認ボタン（承認待ちの時のみ表示） --}}
        @if (Auth::user()->is_admin)
            @if ($attendance->is_locked)
                <form action="{{ route('admin.attendance.approve', $attendance->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">修正リクエストを承認</button>
                </form>
            @else
                <p>✅ 修正リクエスト承認済み</p>
            @endif
        @endif

    </div>
  </main>

</body>
</html>
