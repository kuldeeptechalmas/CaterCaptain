<?php

namespace App\Repository\Interface;

use App\Http\Requests\RegistrationRequest;

interface UserInterface
{
    public function create(RegistrationRequest $request);
    public function findByEmail(string $email);
    public function updatePassword(int $id, string $hashedPassword): bool;
    public function generateUserNumber();
}
