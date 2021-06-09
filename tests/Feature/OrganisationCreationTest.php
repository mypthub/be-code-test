<?php

namespace Tests\Feature;

use App\Events\OrganisationCreated;
use App\Listeners\SendEmailNotificationAboutOrganisationCreated;
use App\Mail\OrganisationCreatedNotification;
use App\Organisation;
use App\User;
use Illuminate\Foundation\Testing\{
    Concerns\InteractsWithAuthentication,
    RefreshDatabase
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
    }

    public function testOrganisationEmailSentListener()
    {
        $user = $this->createUser();
        $organisaton = Organisation::create([
            'name' => 'test',
            'owner_user_id' => $user->id,
            'trial_end' => now()->addDays(30),
        ]); // test org

        Mail::fake();


        \event(new OrganisationCreated($organisaton, $user));

        Mail::assertSent(
            OrganisationCreatedNotification::class,
            function (OrganisationCreatedNotification $mail) use ($user, $organisaton) {
                return $user->id === $mail->getUser()->id && $organisaton->id === $mail->getOrganisation()->id;
            }
        );
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
