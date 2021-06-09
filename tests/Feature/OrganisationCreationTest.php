<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\{
    Concerns\InteractsWithAuthentication,
    RefreshDatabase,
    WithFaker
};

use Tests\TestCase;

class OrganisationCreationTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithAuthentication;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanCreateOrganisation()
    {
        $user = $this->createUser();

        $this->actingAs($user, 'api');

        $this->get(
            route('api.user.me')
        )->assertStatus(200)->assertJson($user->toArray());

        $organisation = [
            'name' => 'TestOrg'
        ];

        $this->post(
            route('api.organisation.create'),
            $organisation
        )->assertJson(['a']);

    }

    protected function createUser(): User
    {
        return User::create([
            'name' => 'test',
            'email' => 'test@test.user',
            'password' => bcrypt('testuser')
        ]);
    }
}
