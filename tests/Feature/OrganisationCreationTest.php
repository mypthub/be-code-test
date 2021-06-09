<?php

namespace Tests\Feature;

use App\Events\OrganisationCreated;
use App\Mail\OrganisationCreatedNotification;
use App\User;
use Illuminate\Foundation\Testing\{
    Concerns\InteractsWithAuthentication,
    RefreshDatabase,
    WithFaker
};

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
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
        Event::fake();
        Mail::fake();

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
        )->assertStatus(200);

        $this->assertDatabaseHas('organisations', $organisation);

        Event::assertDispatched(OrganisationCreated::class);
        Mail::assertSent(OrganisationCreatedNotification::class);


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
