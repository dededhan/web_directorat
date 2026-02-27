<?php

namespace Tests\Feature\InovChallenge\Admin;

use App\Models\User;
use App\Models\InovChallengeSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InovChallengeSessionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user with role
        $this->admin = User::factory()->create([
            'role' => 'inovchalange',
        ]);
    }

    /** @test */
    public function admin_can_view_sessions_index()
    {
        $sessions = InovChallengeSession::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.sessions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.sessions.index');
        $response->assertViewHas('sessions');
    }

    /** @test */
    public function non_admin_cannot_view_sessions_index()
    {
        $user = User::factory()->create(['role' => 'dosen']);

        $response = $this->actingAs($user)
            ->get(route('admin.inov_challenge.sessions.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_create_session_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.sessions.create'));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.sessions.create');
    }

    /** @test */
    public function admin_can_create_session()
    {
        $sessionData = [
            'title' => 'Innovation Challenge 2026',
            'description' => 'Annual innovation challenge for faculty',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(60)->format('Y-m-d'),
            'registration_deadline' => now()->addDays(30)->format('Y-m-d'),
            'max_team_members' => 5,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.store'), $sessionData);

        $response->assertRedirect(route('admin.inov_challenge.sessions.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'title' => 'Innovation Challenge 2026',
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function admin_cannot_create_session_with_invalid_dates()
    {
        $sessionData = [
            'title' => 'Innovation Challenge 2026',
            'description' => 'Annual innovation challenge',
            'start_date' => now()->addDays(60)->format('Y-m-d'),
            'end_date' => now()->addDays(7)->format('Y-m-d'), // End before start
            'registration_deadline' => now()->addDays(30)->format('Y-m-d'),
            'max_team_members' => 5,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.store'), $sessionData);

        $response->assertSessionHasErrors(['end_date']);
    }

    /** @test */
    public function admin_can_view_session_details()
    {
        $session = InovChallengeSession::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.sessions.show', $session));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.sessions.show');
        $response->assertViewHas('session', $session);
    }

    /** @test */
    public function admin_can_view_edit_session_form()
    {
        $session = InovChallengeSession::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.sessions.edit', $session));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.sessions.edit');
        $response->assertViewHas('session', $session);
    }

    /** @test */
    public function admin_can_update_session()
    {
        $session = InovChallengeSession::factory()->create([
            'title' => 'Old Title',
            'status' => 'draft',
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => $session->description,
            'start_date' => $session->start_date->format('Y-m-d'),
            'end_date' => $session->end_date->format('Y-m-d'),
            'registration_deadline' => $session->registration_deadline->format('Y-m-d'),
            'max_team_members' => 5,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.inov_challenge.sessions.update', $session), $updateData);

        $response->assertRedirect(route('admin.inov_challenge.sessions.show', $session));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function admin_cannot_update_active_session_dates()
    {
        $session = InovChallengeSession::factory()->create([
            'status' => 'active',
        ]);

        $updateData = [
            'title' => $session->title,
            'description' => $session->description,
            'start_date' => now()->addDays(100)->format('Y-m-d'), // Try to change date
            'end_date' => $session->end_date->format('Y-m-d'),
            'registration_deadline' => $session->registration_deadline->format('Y-m-d'),
            'max_team_members' => 5,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.inov_challenge.sessions.update', $session), $updateData);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_can_delete_draft_session()
    {
        $session = InovChallengeSession::factory()->create([
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.sessions.destroy', $session));

        $response->assertRedirect(route('admin.inov_challenge.sessions.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('inov_challenge_sessions', [
            'id' => $session->id,
        ]);
    }

    /** @test */
    public function admin_cannot_delete_active_session()
    {
        $session = InovChallengeSession::factory()->create([
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.sessions.destroy', $session));

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session->id,
        ]);
    }

    /** @test */
    public function admin_can_activate_session()
    {
        // Create session with all required forms
        $session = InovChallengeSession::factory()->create([
            'status' => 'draft',
        ]);

        // Create forms for all phases
        $session->formBuilders()->createMany([
            ['phase' => 'phase_1', 'form_config' => [['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true]]],
            ['phase' => 'phase_2', 'form_config' => [['name' => 'plan', 'label' => 'Plan', 'type' => 'textarea', 'required' => true]]],
            ['phase' => 'phase_3', 'form_config' => [['name' => 'report', 'label' => 'Report', 'type' => 'textarea', 'required' => true]]],
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.activate', $session));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session->id,
            'status' => 'active',
        ]);
    }

    /** @test */
    public function admin_cannot_activate_session_without_all_forms()
    {
        $session = InovChallengeSession::factory()->create([
            'status' => 'draft',
        ]);

        // Only create phase_1 form (missing phase_2 and phase_3)
        $session->formBuilders()->create([
            'phase' => 'phase_1',
            'form_config' => [['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true]],
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.activate', $session));

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session->id,
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function admin_can_close_active_session()
    {
        $session = InovChallengeSession::factory()->create([
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.close', $session));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session->id,
            'status' => 'closed',
        ]);
    }

    /** @test */
    public function only_one_session_can_be_active_at_a_time()
    {
        // Set config to strict mode (no auto close)
        config(['inov_challenge.auto_close_active_session' => false]);

        // Create and activate first session
        $session1 = InovChallengeSession::factory()->create(['status' => 'draft']);
        $session1->formBuilders()->createMany([
            ['phase' => 'phase_1', 'form_config' => [['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true]]],
            ['phase' => 'phase_2', 'form_config' => [['name' => 'plan', 'label' => 'Plan', 'type' => 'textarea', 'required' => true]]],
            ['phase' => 'phase_3', 'form_config' => [['name' => 'report', 'label' => 'Report', 'type' => 'textarea', 'required' => true]]],
        ]);
        $session1->update(['status' => 'active']);

        // Try to activate second session
        $session2 = InovChallengeSession::factory()->create(['status' => 'draft']);
        $session2->formBuilders()->createMany([
            ['phase' => 'phase_1', 'form_config' => [['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true]]],
            ['phase' => 'phase_2', 'form_config' => [['name' => 'plan', 'label' => 'Plan', 'type' => 'textarea', 'required' => true]]],
            ['phase' => 'phase_3', 'form_config' => [['name' => 'report', 'label' => 'Report', 'type' => 'textarea', 'required' => true]]],
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.sessions.activate', $session2));

        $response->assertSessionHas('error');

        // Session 1 should still be active
        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session1->id,
            'status' => 'active',
        ]);

        // Session 2 should still be draft
        $this->assertDatabaseHas('inov_challenge_sessions', [
            'id' => $session2->id,
            'status' => 'draft',
        ]);
    }
}
