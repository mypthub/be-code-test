<?php

namespace Tests\Feature;

use App\Organisation;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesUser;
use Tests\TestCase;

class OrganisationListAllTest extends TestCase
{
    use RefreshDatabase, InteractsWithAuthentication, CreatesUser;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListOfAllWithoutFilter()
    {
        $user = $this->createUser();
        $this->actingAs($user, 'api');

        $user->organisations()
            ->create([
                'name' => 'Test 1',
                'trial_end' => now()->addDays(30),
                'subscribed' => 0
            ]);
        $user->organisations()
            ->create([
                'name' => 'Test 2',
                'trial_end' => now()->addDays(-30),
            ]);
        $user->organisations()
            ->create([
                'name' => 'Test 3',
                'trial_end' => now()->addDays(30),
                'subscribed' => 1,
            ]);

        $this->get(
            route('api.organisation.list')
        )->assertJsonCount(3, 'data.organisations');

        $this->get(
            route('api.organisation.list', ['filter' =>'all'])
        )->assertJsonCount(3, 'data.organisations');

        $this->get(
            route('api.organisation.list', ['filter' => 'trial'])
        )->assertJsonCount(1, 'data.organisations');

        $this->get(
            route('api.organisation.list', ['filter' => 'subbed'])
        )->assertJsonCount(1, 'data.organisations');

    }
}
