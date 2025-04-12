<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者用申請一覧</title>
  <link rel="stylesheet" href="{{ asset('css/stamp_correction_request.css') }}">
</head>
<body>
  <header>
    <div class="header-container">
      <h1 class="logo">COACHTECH</h1>
      <nav>
        <ul>
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
      <h2 class="title">管理者用 申請一覧</h2>

     
      <div class="tabs">
        <ul>
          <li class="tab active" data-tab="pending">承認待ち</li>
          <li class="tab" data-tab="approved">承認済み</li>
        </ul>
      </div>

      <div class="tab-content">
        <div class="tab-pane active" id="pending">
          <table class="attendance-table">
            <thead>
              <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pendingRequests as $detail)
                <tr>
                  <td>承認待ち</td>
                  <td>{{ $detail->attendance->user->name ?? '-' }}</td>
                  <td>{{ $detail->attendance->created_at->format('Y年 m月d日') }}</td>
                  <td>{{ $detail->request_reason }}</td>
                  <td>{{ $detail->updated_at->format('Y年 m月d日') }}</td>
                  <td><a href="{{ route('admin.stamp_correction_request.approve', $detail) }}">詳細</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="tab-pane" id="approved">
          <table class="attendance-table">
            <thead>
              <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
              </tr>
            </thead>
            <tbody>
              @foreach($approvedRequests as $detail)
                <tr>
                  <td>承認済み</td>
                  <td>{{ $detail->attendance->user->name ?? '-' }}</td>
                  <td>{{ $detail->attendance->created_at->format('Y年 m月d日') }}</td>
                  <td>{{ $detail->request_reason }}</td>
                  <td>{{ $detail->updated_at->format('Y年 m月d日') }}</td>
                  <td><a href="{{ route('admin.stamp_correction_request.approve', $detail) }}">詳細</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab').forEach(tab => {
      tab.addEventListener('click', function () {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(this.getAttribute('data-tab')).classList.add('active');
      });
    });
  });
</script>


</body>
</html>
