<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_sections_load_successfully(): void
    {
        $this->get('/teams')->assertStatus(200);
        $this->get('/projects')->assertStatus(200);
        $this->get('/branches')->assertStatus(200);
        $this->get('/servers')->assertStatus(200);
        $this->get('/feed')->assertStatus(200);
        $this->get('/showcase')->assertStatus(200);
        $this->get('/announcements')->assertStatus(200);
        $this->get('/academy')->assertStatus(200);
        $this->get('/academy/courses')->assertStatus(200);
        $this->get('/academy/live-sessions')->assertStatus(200);
        $this->get('/academy/labs')->assertStatus(200);
    }

    public function test_authenticated_user_can_create_team_and_project(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/teams', [
                'name' => 'Test Team',
                'description' => 'A test team description',
            ])
            ->assertRedirect('/teams');

        $this->assertDatabaseHas('teams', ['name' => 'Test Team']);

        $this->actingAs($user)
            ->post('/projects', [
                'name' => 'Test Project',
                'description' => 'A test project description',
            ])
            ->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', ['name' => 'Test Project']);
    }
}
