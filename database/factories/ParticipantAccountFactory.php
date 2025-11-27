<?php

namespace Database\Factories;

use App\Models\ParticipantAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Uid\Ulid;

/**
 * @extends Factory<ParticipantAccount>
 */
class ParticipantAccountFactory extends Factory
{
    public function definition(): array
    {
        $full_name = fake()->firstName() . ' ' . fake()->lastName();
        $email = fake()->email();

        // Default password untuk factory ini (jangan lupa titiknya): P4$$word.
        $password = '$argon2id$v=19$m=65536,t=3,p=1$6LuftmlqbGViZY+EU9lH3AJMNLnCGnURLEe2b6MdnIo$rdEjzN4sIGIf2HtdSOh8RmKcOV98VBkXknYSURo3HyY';
        $role = 'PARTICIPANT';

        return [
            'account_id' => Ulid::generate(),
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ];
    }
}
