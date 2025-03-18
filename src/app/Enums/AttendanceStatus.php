<?php

namespace App\Enums;

enum AttendanceStatus: int
{
    case WORKING = 1;
    case BREAK = 2;
    case OFF_DUTY = 3;
    case FINISHED = 4;

    public function label(): string
    {
        return match ($this) {
            self::WORKING => '勤務中',
            self::BREAK => '休憩中',
            self::OFF_DUTY => '勤務外',
            self::FINISHED => '終了',
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            '勤務中' => self::WORKING,
            '休憩中' => self::BREAK,
            '勤務外' => self::OFF_DUTY,
            '終了' => self::FINISHED,
            default => throw new \InvalidArgumentException("不明なステータス: $label"),
        };
    }
}
