<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠登録画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>勤怠登録画面</h1>
    <p>現在の日時: {{ $currentDateTime }}</p>
    <p>現在のステータス: {{ $status }}</p>

    @if($status === '勤務外')
        <form action="{{ route('attendance.checkIn') }}" method="POST">
            @csrf
            <button type="submit">出勤</button>
        </form>
    @elseif($status === '勤務中')
        <form action="{{ route('attendance.breakStart') }}" method="POST">
            @csrf
            <button type="submit">休憩</button>
        </form>
        <form action="{{ route('attendance.checkOut') }}" method="POST">
            @csrf
            <button type="submit">退勤</button>
        </form>
    @elseif($status === '休憩中')
        <form action="{{ route('attendance.breakEnd') }}" method="POST">
            @csrf
            <button type="submit">休憩戻</button>
        </form>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
</body>
</html>
