<?php

namespace App\Repository;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Repository\Interface\UserInterface;
use Illuminate\Support\Facades\Hash;

class  UserRepository implements UserInterface
{
    public function create(RegistrationRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->user_number = $this->generateUserNumber();
        $user->is_active = true;
        $user->save();

        return $user;
    }

    public function generateUserNumber(): string
    {
        do {
            $number = 'USR-' . date('Y') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $exists = User::where('user_number', $number)->exists();
        } while ($exists);

        return $number;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updatePassword(int $id, string $hashedPassword): bool
    {
        return User::where('id', $id)->update(['password' => $hashedPassword]) > 0;
    }
}
