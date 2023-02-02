<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Services\AppService;
use Illuminate\Support\Facades\Auth;

/**
 * Class UpdateProfileService
 * @package App\Services\User
 */
class UpdateProfileService extends AppService
{
    /**
     * @param array $profileDTO
     * @return User
     */
    public function run(array $profileDTO): User
    {
        return $this->updateProfile($profileDTO);
    }

    /**
     * Update profile
     *
     * @param array $profileDTO
     * @return User
     */
    private function updateProfile(array $profileDTO): User
    {
        $user = Auth::user();

        $user
            ->fill($profileDTO)
            ->save();

        return $user->refresh();
    }
}
