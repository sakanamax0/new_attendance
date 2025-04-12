<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修正申請承認</title>
    <link rel="stylesheet" href="{{ asset('css/approve.css') }}"> <!-- 外部CSSを適用 -->
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

<div class="container">
    <h2>勤怠詳細</h2>
    <table>
        <tr>
            <th>名前</th>
            <td>{{ $detail->attendance->user->name }}</td>
        </tr>
        <tr>
            <th>日付</th>
            <td>{{ $detail->attendance->clock_in ? $detail->attendance->clock_in->format('Y-m-d') : '' }}</td>
        </tr>
        <tr>
            <th>出勤・退勤</th>
            <td>{{ $detail->attendance->clock_in }} 〜 {{ $detail->attendance->clock_out }}</td>
        </tr>
        
        <tr>
            <th>休憩時間</th>
            <td>
                @forelse ($detail->attendance->breaktimes as $breaktime)
                    {{ $breaktime->break_start_time }} 〜 {{ $breaktime->break_end_time }}<br>
                @empty
                    登録なし
                @endforelse
            </td>
        </tr>
        
        <tr>
            <th>備考</th>
            <td>{{ $detail->request_reason }}</td> <!-- request_reason カラムを表示 -->
        </tr>
    </table>

    {{-- 承認済みの場合 --}}
    @if ($detail->remarks == 1)
        <p>承認済み</p>
    @else
        <form method="POST" action="{{ route('admin.stamp_correction_request.approve.submit', $detail->id) }}">
            @csrf
            @method('POST') {{-- approve.submit は POST メソッドなのでここは POST --}}
            <button type="submit" class="btn">承認</button>
        </form>
    @endif
</div>

</body>
</html>
