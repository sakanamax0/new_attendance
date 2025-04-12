<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠詳細</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
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
            <h2 class="title">勤怠詳細</h2>

            
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

            
            @if(session('success'))
                <div style="color: green; padding: 10px; border: 1px solid green;">
                    {{ session('success') }}
                </div>
            @endif

            
            <div class="attendance-details">
                <div>
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
                </div>

                <div>
                    <form action="{{ route('admin.attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <table class="attendance-table">
                            <tr>
                                <th>出勤・退勤</th>
                                <td>
                                    <input type="time" name="request_clock_in" 
                                           value="{{ old('request_clock_in', optional($attendance->clock_in)->format('H:i')) }}" />
                                    ～ 
                                    <input type="time" name="request_clock_out" 
                                           value="{{ old('request_clock_out', optional($attendance->clock_out)->format('H:i')) }}" />
                                </td>
                            </tr>

                            
                            @foreach ($breaktimes as $index => $breaktime)
                                <tr>
                                    <th>休憩{{ $index + 1 }}</th>
                                    <td>
                                        <input type="time" name="break_start_time[]" 
                                               value="{{ old('break_start_time[]', optional($breaktime->break_start_time)->format('H:i')) }}" />
                                        ～ 
                                        <input type="time" name="break_end_time[]" 
                                               value="{{ old('break_end_time[]', optional($breaktime->break_end_time)->format('H:i')) }}" />
                                    </td>
                                </tr>
                            @endforeach

                           
                            <tr>
                                <th>備考</th>
                                <td>
                                    <textarea id="reason" name="reason" rows="3">{{ old('reason', $attendance->reason) }}</textarea>
                                </td>
                            </tr>
                        </table>

                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">修正</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
