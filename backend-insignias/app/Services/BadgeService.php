<?php

namespace App\Services;

use App\Models\User;
use App\Models\Badge;

class BadgeService
{
    public function evaluate(User $user, $totalAhorrado = 0)
    {
        $this->checkFirstDeposit($user, $totalAhorrado);
        $this->checkTotalSaved($user, $totalAhorrado);
    }

    private function checkFirstDeposit(User $user, $totalAhorrado)
    {
        if ($totalAhorrado > 0) {
            $this->awardBadge($user, 'primer_ahorro');
        }
    }

    private function checkTotalSaved(User $user, $totalAhorrado)
    {
        if ($totalAhorrado >= 5000) $this->awardBadge($user, 'cerdito_feliz');
        if ($totalAhorrado >= 10000) $this->awardBadge($user, 'constante_tortuga');
        if ($totalAhorrado >= 30000) $this->awardBadge($user, 'vision_financiera');
        if ($totalAhorrado >= 60000) $this->awardBadge($user, 'maestro_ahorro');
        if ($totalAhorrado >= 100000) $this->awardBadge($user, 'meta_millennial');
    }

    private function awardBadge(User $user, $badgeKeyName)
    {
        $badge = Badge::where('key_name', $badgeKeyName)->first();

        if ($badge && !$user->badges()->where('insignia_id', $badge->id)->exists()) {
            $user->badges()->syncWithoutDetaching([
                $badge->id => [
                    'completada' => 1,
                    'fecha_desbloqueo' => now()
                ]
            ]);
        }
    }
}