<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'clock_in' => ['nullable', 'date_format:H:i'],
            'clock_out' => ['nullable', 'date_format:H:i', 'after:clock_in'],
            'break_start_time' => ['nullable', 'date_format:H:i', 'after_or_equal:clock_in', 'before_or_equal:clock_out'],
            'break_end_time' => ['nullable', 'date_format:H:i', 'after:break_start_time', 'before_or_equal:clock_out'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'clock_out.after' => '退勤時間は出勤時間より後である必要があります。',
            'break_start_time.after_or_equal' => '休憩開始時間は勤務時間内である必要があります。',
            'break_end_time.after' => '休憩終了時間は休憩開始時間より後である必要があります。',
            'remarks.max' => '備考は255文字以内で入力してください。',
        ];
    }
}
