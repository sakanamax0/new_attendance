<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>勤怠一覧</title>
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
    <h2 class="title">勤怠一覧</h2>

    <div class="month-navigation">
      <form method="GET" action="{{ route('attendance.list') }}">
        <input type="hidden" name="month" value="{{ $prevMonth ?? '' }}">
        <button type="submit" class="btn btn-secondary">前月</button>
      </form>
      <h4 class="current-month">{{ ($currentMonth ?? now())->format('Y年m月') }}</h4>
      <form method="GET" action="{{ route('attendance.list') }}">
        <input type="hidden" name="month" value="{{ $nextMonth ?? '' }}">
        <button type="submit" class="btn btn-secondary">翌月</button>
      </form>
    </div>

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
      <td>{{ $attendance->clock_in ? $attendance->clock_in->formatLocalized('%m/%d (%a)') : '-' }}</td>
      <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
      <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
      <td>
        @php
          $breakMinutes = ($attendance->break_start_time && $attendance->break_end_time)
                         ? $attendance->break_end_time->diffInMinutes($attendance->break_start_time)
                         : 0;
        @endphp
        {{ floor($breakMinutes / 60) }}時間 {{ $breakMinutes % 60 }}分
      </td>
      <td>
        @if ($attendance->clock_in && $attendance->clock_out)
          @php
            $workHours = $attendance->clock_out->diffInMinutes($attendance->clock_in);
            $actualWorkTime = max(0, $workHours - $breakMinutes);
          @endphp
          {{ floor($actualWorkTime / 60) }}時間 {{ $actualWorkTime % 60 }}分
        @else
          -
        @endif
      </td>
      <td>
        <a href="{{ route('attendance.detail', ['id' => $attendance->id]) }}" class="btn btn-primary">詳細</a>
      </td>
    </tr>
  @endforeach
</tbody>
    </table>
  </div>   
 </main>
</body>
</html>
