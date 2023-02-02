<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Exceptions\ValidationErrorException;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfilePasswordService
 * @package App\Services\User
 */
class ProfilePasswordService extends AppService
{
    /**
     * ProfilePasswordService constructor.
     * @param UpdatePasswordService $updatePasswordService
     */
    public function __construct(private readonly UpdatePasswordService $updatePasswordService)
    {

    }

    /**
     * @throws ValidationErrorException
     */
    public function run(array $dataDTO): User
    {
        return $this->updatePassword($dataDTO);
    }

    /**
     * @param array $dataDTO
     * @return User
     * @throws ValidationErrorException
     */
    private function updatePassword(array $dataDTO): User
    {
        $user = Auth::user();

        // Check password
        if (!Hash::check($dataDTO['current_password'], $user->password)) {
            throw new ValidationErrorException(__('auth.not_valid_password'));
        }
        $data = ['password' => $dataDTO['new_password']];

        return $this->updatePasswordService->run($data, $user);
    }
}
