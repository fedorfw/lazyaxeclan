<?php

namespace users\app\transformers;

use League\Fractal\TransformerAbstract;
use users\Domain\Entities\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
        ];
    }

}
