<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Services\AppService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserByEmailService
 * @package App\Services\User
 */
class UserByEmailService extends AppService
{
    /**
     * @param string $email
     * @return Model|Builder|User|null
     */
    public function run(string $email): Model|Builder|User|null
    {
        return $this->getUserByEmail($email);
    }

    /**
     * @param string $email
     * @return Model|Builder|User|null
     */
    private function getUserByEmail(string $email): Model|Builder|User|null
    {
        return User::query()->where('email', $email)
            ->first();
    }
}
