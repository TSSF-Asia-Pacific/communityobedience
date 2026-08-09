<?php

declare(strict_types=1);

namespace Tssf\Communityobedience;

/**
 * Looks up the living and deceased members we are praying for, per day of the month
 */
class DailyPrayers
{
    public function __construct(private readonly string $commonDir)
    {
    }

    public function getMembersForAllDays(): array
    {
        $dailyTemplateVars = [];
        for ($day = 1; $day <= 31; $day++) {
            $dailyTemplateVars[$day] = $this->getMembersForDay($day);
        }

        return $dailyTemplateVars;
    }

    public function getMembersForDay(int $day): array
    {
        $templateVars = [];
        foreach (range(1, 3) as $region) {
            $filename = "{$this->commonDir}/{$day}_living_members_{$region}.txt";
            if (file_exists($filename)) {
                $templateVars["living_members_{$region}"] = trim(file_get_contents($filename));
            }
        }

        $deceasedMembersFilename = "{$this->commonDir}/{$day}_deceased_members.txt";
        if (file_exists($deceasedMembersFilename)) {
            $templateVars['deceased_members'] = trim(file_get_contents($deceasedMembersFilename));
        }

        return $templateVars;
    }
}
