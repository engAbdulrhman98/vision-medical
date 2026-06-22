<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // By default, make sure all days are closed first or set standard defaults.
        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        foreach ($days as $day) {
            Setting::setValue("day_{$day}_open", '0');
            Setting::setValue("day_{$day}_from", '08:00');
            Setting::setValue("day_{$day}_to", '17:00');
        }
    }

    public function test_all_days_closed(): void
    {
        $this->assertEquals('مغلق', Setting::getWorkingHoursDisplay('ar'));
        $this->assertEquals('Closed', Setting::getWorkingHoursDisplay('en'));
    }

    public function test_single_open_day(): void
    {
        Setting::setValue('day_sunday_open', '1');
        
        $this->assertEquals('الأحد: 8:00 ص - 5:00 م', Setting::getWorkingHoursDisplay('ar'));
        $this->assertEquals('Sun: 8:00 AM - 5:00 PM', Setting::getWorkingHoursDisplay('en'));
    }

    public function test_consecutive_days_range(): void
    {
        // Sat, Sun, Mon, Tue, Wed, Thu
        Setting::setValue('day_saturday_open', '1');
        Setting::setValue('day_sunday_open', '1');
        Setting::setValue('day_monday_open', '1');
        Setting::setValue('day_tuesday_open', '1');
        Setting::setValue('day_wednesday_open', '1');
        Setting::setValue('day_thursday_open', '1');

        $this->assertEquals('من السبت إلى الخميس: 8:00 ص - 5:00 م', Setting::getWorkingHoursDisplay('ar'));
        $this->assertEquals('From Sat to Thu: 8:00 AM - 5:00 PM', Setting::getWorkingHoursDisplay('en'));
    }

    public function test_consecutive_days_subset(): void
    {
        // Sun, Mon, Tue
        Setting::setValue('day_sunday_open', '1');
        Setting::setValue('day_monday_open', '1');
        Setting::setValue('day_tuesday_open', '1');

        $this->assertEquals('من الأحد إلى الثلاثاء: 8:00 ص - 5:00 م', Setting::getWorkingHoursDisplay('ar'));
        $this->assertEquals('From Sun to Tue: 8:00 AM - 5:00 PM', Setting::getWorkingHoursDisplay('en'));
    }

    public function test_disconnected_days(): void
    {
        // Sat, Mon, Wed
        Setting::setValue('day_saturday_open', '1');
        Setting::setValue('day_monday_open', '1');
        Setting::setValue('day_wednesday_open', '1');

        $this->assertEquals('السبت، الاثنين، الأربعاء: 8:00 ص - 5:00 م', Setting::getWorkingHoursDisplay('ar'));
        $this->assertEquals('Sat, Mon, Wed: 8:00 AM - 5:00 PM', Setting::getWorkingHoursDisplay('en'));
    }
}
