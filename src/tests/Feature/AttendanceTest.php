<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_check_in()
    {
        $user = User::factory()->create();  // ユーザーを作成

        // ユーザーでログイン
        $this->actingAs($user);

        // 出勤処理を実行
        $response = $this->post(route('attendance.checkIn'));

        // DBに出勤データがあるかを確認
        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'check_in' => now()->format('Y-m-d H:i:s'),  // 時間をチェックイン時の時間に合わせる
        ]);

        // 出勤後、ユーザーがリダイレクトされるかを確認
        $response->assertRedirect('/attendance');
    }

    /** @test */
    public function user_can_check_out()
    {
        $user = User::factory()->create();  // ユーザーを作成

        // ユーザーでログイン
        $this->actingAs($user);

        // 出勤して、退勤処理を実行
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'check_in' => now()->subHours(2),  // 2時間前にチェックインしたと仮定
        ]);

        $response = $this->post(route('attendance.checkOut', ['attendance_id' => $attendance->id]));

        // DBに退勤データがあるかを確認
        $attendance->refresh();
        $this->assertNotNull($attendance->check_out);

        // 退勤後、ユーザーがリダイレクトされるかを確認
        $response->assertRedirect('/attendance');
    }
}
