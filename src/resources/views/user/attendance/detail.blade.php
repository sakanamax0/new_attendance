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
        <h2 class="title">勤怠詳細</h2>

        {{-- ✅ バリデーションエラーの表示 --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <p>入力内容に誤りがあります。以下を修正してください。</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ 勤怠詳細情報の表示 --}}
        <table class="attendance-table">
            <tr>
                <th>名前</th>
                <td>{{ $attendance->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>{{ $attendance->clock_in ? $attendance->clock_in->format('Y年 m月d日') : '-' }}</td>
            </tr>
        </table>

        {{-- ✅ 休憩時間の表示 --}}
        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>出勤時間:</label>
            <input type="time" name="request_clock_in" 
                   value="{{ old('request_clock_in', optional($attendance->clock_in)->format('H:i')) }}"
                   @if ($detail && $detail->remarks == 0) disabled @endif>

            <label>退勤時間:</label>
            <input type="time" name="request_clock_out" 
                   value="{{ old('request_clock_out', optional($attendance->clock_out)->format('H:i')) }}"
                   @if ($detail && $detail->remarks == 0) disabled @endif>

            {{-- 休憩時間入力 --}}
            @foreach ($breaktimes as $breaktime)
                <div>
                    <label>休憩開始:</label>
                    <input type="time" name="break_start_time[]"
                           value="{{ old('break_start_time[]', optional($breaktime->break_start_time)->format('H:i')) }}"
                           @if ($detail && $detail->remarks == 0) disabled @endif>

                    <label>休憩終了:</label>
                    <input type="time" name="break_end_time[]"
                           value="{{ old('break_end_time[]', optional($breaktime->break_end_time)->format('H:i')) }}"
                           @if ($detail && $detail->remarks == 0) disabled @endif>
                </div>
            @endforeach

            <label>申請理由:</label>
            <textarea name="request_reason" @if ($detail && $detail->remarks == 0) disabled @endif>
                {{ old('request_reason', $attendance->request_reason ?? '') }}
            </textarea>

            {{-- 承認待ちでなければ「修正を申請」ボタンを表示 --}}
            @if (!$detail || $detail->remarks != 0)
                <button type="submit" class="btn btn-primary">修正を申請</button>
            @endif
            
            @if ($detail->remarks == 0)
                <p class="text-danger">＊現在承認待ちのため修正できません。</p>
            @endif
        </form>
    </div>
  </main>

</body>
</html>
