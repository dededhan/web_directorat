<?php

namespace Tests\Feature\InovChallenge\Admin;

use App\Models\User;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeFormBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InovChallengeFormBuilderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'inovchalange']);
        $this->session = InovChallengeSession::factory()->create(['status' => 'draft']);
    }

    /** @test */
    public function admin_can_view_form_builders_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.forms.index', $this->session));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.forms.index');
        $response->assertViewHas('session', $this->session);
    }

    /** @test */
    public function admin_can_view_create_form_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.forms.create', ['session' => $this->session, 'phase' => 'phase_1']));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.forms.create');
        $response->assertViewHas('phase', 'phase_1');
    }

    /** @test */
    public function admin_can_create_form_builder()
    {
        $formConfig = [
            ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true],
            ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'required' => true],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.forms.store', $this->session), [
                'phase' => 'phase_1',
                'form_config' => json_encode($formConfig),
            ]);

        $response->assertRedirect(route('admin.inov_challenge.forms.index', $this->session));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_form_builders', [
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);
    }

    /** @test */
    public function admin_cannot_create_duplicate_form_for_same_phase()
    {
        // Create first form
        InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);

        $formConfig = [
            ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'required' => true],
        ];

        // Try to create another form for same phase
        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.forms.store', $this->session), [
                'phase' => 'phase_1',
                'form_config' => json_encode($formConfig),
            ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_cannot_create_form_with_invalid_config()
    {
        $invalidConfig = [
            ['name' => 'title'], // Missing label and type
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.forms.store', $this->session), [
                'phase' => 'phase_1',
                'form_config' => json_encode($invalidConfig),
            ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_can_view_edit_form_page()
    {
        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.forms.edit', ['session' => $this->session, 'form' => $form]));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.forms.edit');
        $response->assertViewHas('form', $form);
    }

    /** @test */
    public function admin_can_update_form_builder()
    {
        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
            'form_config' => [
                ['name' => 'old_field', 'label' => 'Old', 'type' => 'text', 'required' => true],
            ],
        ]);

        $newConfig = [
            ['name' => 'new_field', 'label' => 'New', 'type' => 'text', 'required' => true],
            ['name' => 'another_field', 'label' => 'Another', 'type' => 'textarea', 'required' => true],
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.inov_challenge.forms.update', ['session' => $this->session, 'form' => $form]), [
                'form_config' => json_encode($newConfig),
            ]);

        $response->assertRedirect(route('admin.inov_challenge.forms.index', $this->session));
        $response->assertSessionHas('success');

        $form->refresh();
        $this->assertCount(2, $form->form_config);
        $this->assertEquals('new_field', $form->form_config[0]['name']);
    }

    /** @test */
    public function admin_can_delete_form_builder()
    {
        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.forms.destroy', ['session' => $this->session, 'form' => $form]));

        $response->assertRedirect(route('admin.inov_challenge.forms.index', $this->session));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('inov_challenge_form_builders', [
            'id' => $form->id,
        ]);
    }

    /** @test */
    public function admin_cannot_delete_form_when_session_is_active()
    {
        $this->session->update(['status' => 'active']);

        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.forms.destroy', ['session' => $this->session, 'form' => $form]));

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('inov_challenge_form_builders', [
            'id' => $form->id,
        ]);
    }

    /** @test */
    public function admin_can_view_form_preview()
    {
        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.forms.preview', ['session' => $this->session, 'form' => $form]));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.forms.preview');
        $response->assertViewHas('form', $form);
    }

    /** @test */
    public function form_config_must_be_valid_json()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.forms.store', $this->session), [
                'phase' => 'phase_1',
                'form_config' => 'invalid json',
            ]);

        $response->assertSessionHasErrors(['form_config']);
    }

    /** @test */
    public function form_validation_rules_can_be_retrieved()
    {
        $form = InovChallengeFormBuilder::factory()->create([
            'session_id' => $this->session->id,
            'phase' => 'phase_1',
            'form_config' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ],
        ]);

        // Set debug mode
        config(['app.debug' => true]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.forms.validation_rules', ['session' => $this->session, 'form' => $form]));

        $response->assertStatus(200);
        $response->assertJson([
            'phase' => 'phase_1',
        ]);
        $response->assertJsonStructure([
            'validation_rules',
            'validation_messages',
            'validation_attributes',
            'required_fields',
        ]);
    }
}
