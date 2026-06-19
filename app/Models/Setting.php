<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get setting value by key.
     */
    public static function getValue(string $key, $default = null): ?string
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key.
     */
    public static function setValue(string $key, ?string $value): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get formatted working hours display string dynamically.
     */
    public static function getWorkingHoursDisplay(string $locale = 'ar'): string
    {
        $daysConfig = [
            'saturday'  => ['ar' => 'السبت', 'en' => 'Sat'],
            'sunday'    => ['ar' => 'الأحد', 'en' => 'Sun'],
            'monday'    => ['ar' => 'الاثنين', 'en' => 'Mon'],
            'tuesday'   => ['ar' => 'الثلاثاء', 'en' => 'Tue'],
            'wednesday' => ['ar' => 'الأربعاء', 'en' => 'Wed'],
            'thursday'  => ['ar' => 'الخميس', 'en' => 'Thu'],
            'friday'    => ['ar' => 'الجمعة', 'en' => 'Fri'],
        ];

        $openDays = [];
        foreach ($daysConfig as $dayKey => $dayNames) {
            $isOpen = self::getValue("day_{$dayKey}_open", $dayKey === 'friday' ? '0' : '1');
            if ($isOpen === '1' || $isOpen === 1 || $isOpen === true || $isOpen === 'true') {
                $from = self::getValue("day_{$dayKey}_from", '08:00');
                $to = self::getValue("day_{$dayKey}_to", '17:00');
                $openDays[$dayKey] = [
                    'name' => $dayNames[$locale] ?? $dayNames['en'],
                    'from' => $from,
                    'to' => $to
                ];
            }
        }

        if (empty($openDays)) {
            return $locale === 'ar' ? 'مغلق' : 'Closed';
        }

        $firstDay = reset($openDays);
        $allSameTime = true;
        foreach ($openDays as $day) {
            if ($day['from'] !== $firstDay['from'] || $day['to'] !== $firstDay['to']) {
                $allSameTime = false;
                break;
            }
        }

        $formatTime = function($timeStr) use ($locale) {
            $timestamp = strtotime($timeStr);
            if ($locale === 'ar') {
                $formatted = date('g:i', $timestamp);
                $suffix = date('A', $timestamp) === 'AM' ? 'ص' : 'م';
                return $formatted . ' ' . $suffix;
            } else {
                return date('g:i A', $timestamp);
            }
        };

        $timeRangeStr = $formatTime($firstDay['from']) . ' - ' . $formatTime($firstDay['to']);

        if ($allSameTime) {
            $openDayKeys = array_keys($openDays);
            if (count($openDayKeys) === 6 && !in_array('friday', $openDayKeys) && $openDayKeys[0] === 'saturday' && end($openDayKeys) === 'thursday') {
                if ($locale === 'ar') {
                    return 'السبت - الخميس: ' . $timeRangeStr;
                } else {
                    return 'Sat - Thu: ' . $timeRangeStr;
                }
            }
            
            $dayNamesList = array_map(function($day) {
                return $day['name'];
            }, $openDays);
            
            if ($locale === 'ar') {
                return implode('، ', $dayNamesList) . ': ' . $timeRangeStr;
            } else {
                return implode(', ', $dayNamesList) . ': ' . $timeRangeStr;
            }
        } else {
            $lines = [];
            foreach ($openDays as $day) {
                $lines[] = $day['name'] . ': ' . $formatTime($day['from']) . ' - ' . $formatTime($day['to']);
            }
            return implode(' | ', $lines);
        }
    }
}
