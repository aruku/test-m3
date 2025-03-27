<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CurrencyConverterTest extends TestCase
{
    public function test_successful_conversion(): void
    {
        // TODO DEDUPLICATE THIS AUTH LOGIC SOMEHOW
        /** @var User $user */
        $user = User::where('email', 'test@example.com')->first();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/convert/13/eur/usd/');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('eur', 13)
                ->whereType('usd', 'double')
                ->etc()
        );
    }

    public function test_nonexistent_from_currency(): void
    {
        /** @var User $user */
        $user = User::where('email', 'test@example.com')->first();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/convert/13/foo/usd/');

        $response->assertStatus(404);
    }

    public function test_nonexistent_to_currency(): void
    {
        /** @var User $user */
        $user = User::where('email', 'test@example.com')->first();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/convert/13/eur/bar/');

        $response->assertStatus(404);
    }

    public function test_missing_currency(): void
    {
        $response = $this->get('/api/convert/13/eur/');

        $response->assertStatus(404);
    }

    public function test_not_a_number(): void
    {
        /** @var User $user */
        $user = User::where('email', 'test@example.com')->first();
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/convert/AA/eur/usd/');

        $response->assertStatus(500);
    }
}
