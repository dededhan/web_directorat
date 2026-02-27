<?php

namespace Tests\Feature\InovChallenge\Admin;

use App\Models\User;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InovChallengeSubmissionsExport;

class InovChallengeSubmissionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $session;
    protected $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'inovchalange']);
        $this->dosen = User::factory()->create(['role' => 'dosen']);
        $this->session = InovChallengeSession::factory()->create(['status' => 'active']);
    }

    /** @test */
    public function admin_can_view_submissions_index()
    {
        $submissions = InovChallengeSubmission::factory()->count(3)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.submissions.index');
        $response->assertViewHas('submissions');
    }

    /** @test */
    public function admin_can_filter_submissions_by_session()
    {
        $session2 = InovChallengeSession::factory()->create();

        InovChallengeSubmission::factory()->count(2)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
        ]);

        InovChallengeSubmission::factory()->count(3)->create([
            'session_id' => $session2->id,
            'user_id' => $this->dosen->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.index', ['session_id' => $this->session->id]));

        $response->assertStatus(200);
        $submissions = $response->viewData('submissions');
        $this->assertCount(2, $submissions);
    }

    /** @test */
    public function admin_can_filter_submissions_by_status()
    {
        InovChallengeSubmission::factory()->count(2)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'final_status' => 'approved',
        ]);

        InovChallengeSubmission::factory()->count(3)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'final_status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.index', ['status' => 'approved']));

        $response->assertStatus(200);
        $submissions = $response->viewData('submissions');
        $this->assertCount(2, $submissions);
    }

    /** @test */
    public function admin_can_search_submissions()
    {
        InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'title' => 'AI Innovation',
        ]);

        InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'title' => 'Blockchain Tech',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.index', ['search' => 'AI']));

        $response->assertStatus(200);
        $submissions = $response->viewData('submissions');
        $this->assertCount(1, $submissions);
        $this->assertEquals('AI Innovation', $submissions->first()->title);
    }

    /** @test */
    public function admin_can_view_submission_details()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.show', $submission));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.submissions.show');
        $response->assertViewHas('submission', $submission);
    }

    /** @test */
    public function admin_can_approve_phase_with_valid_requirements()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'reviewed',
        ]);

        // Create reviews meeting requirements
        $reviewer1 = User::factory()->create(['role' => 'reviewer_inovchalange']);
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer1->id,
            'phase' => 'phase_1',
            'score' => 80,
            'status' => 'completed',
        ]);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_1',
            'score' => 75,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.approve', ['submission' => $submission, 'phase' => 'phase_1']));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $submission->refresh();
        $this->assertEquals('approved', $submission->phase_1_status);
    }

    /** @test */
    public function admin_cannot_approve_phase_without_minimum_reviews()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'reviewed',
        ]);

        // Only one review (need 2 minimum)
        $reviewer = User::factory()->create(['role' => 'reviewer_inovchalange']);
        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer->id,
            'phase' => 'phase_1',
            'score' => 80,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.approve', ['submission' => $submission, 'phase' => 'phase_1']));

        $response->assertSessionHas('error');

        $submission->refresh();
        $this->assertEquals('reviewed', $submission->phase_1_status);
    }

    /** @test */
    public function admin_cannot_approve_phase_with_low_score()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'reviewed',
        ]);

        // Create reviews with low scores
        $reviewer1 = User::factory()->create(['role' => 'reviewer_inovchalange']);
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer1->id,
            'phase' => 'phase_1',
            'score' => 60, // Below minimum
            'status' => 'completed',
        ]);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_1',
            'score' => 65, // Below minimum
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.approve', ['submission' => $submission, 'phase' => 'phase_1']));

        $response->assertSessionHas('error');

        $submission->refresh();
        $this->assertEquals('reviewed', $submission->phase_1_status);
    }

    /** @test */
    public function admin_can_reject_phase_with_reason()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.reject', ['submission' => $submission, 'phase' => 'phase_1']), [
                'rejection_reason' => 'Proposal tidak sesuai dengan tema innovation challenge yang ditentukan.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $submission->refresh();
        $this->assertEquals('rejected', $submission->phase_1_status);
    }

    /** @test */
    public function rejection_reason_must_be_provided()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.reject', ['submission' => $submission, 'phase' => 'phase_1']), [
                'rejection_reason' => '',
            ]);

        $response->assertSessionHasErrors(['rejection_reason']);
    }

    /** @test */
    public function rejection_reason_must_be_at_least_10_characters()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.reject', ['submission' => $submission, 'phase' => 'phase_1']), [
                'rejection_reason' => 'Too short', // Less than 10 characters
            ]);

        $response->assertSessionHasErrors(['rejection_reason']);
    }

    /** @test */
    public function admin_can_manually_unlock_phase()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'approved',
            'phase_2_status' => null,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.unlock_phase', ['submission' => $submission, 'phase' => 'phase_2']));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $submission->refresh();
        $this->assertEquals('draft', $submission->phase_2_status);
    }

    /** @test */
    public function admin_can_get_phase_status_as_json()
    {
        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'approved',
        ]);

        // Create reviews
        $reviewer1 = User::factory()->create(['role' => 'reviewer_inovchalange']);
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer1->id,
            'phase' => 'phase_1',
            'score' => 85,
            'status' => 'completed',
        ]);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_1',
            'score' => 90,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.phase_status', $submission));

        $response->assertStatus(200);
        $response->assertJson([
            'submission_id' => $submission->id,
            'final_status' => $submission->final_status,
        ]);
        $response->assertJsonStructure([
            'submission_id',
            'final_status',
            'phases' => [
                'phase_1' => [
                    'status',
                    'review_count',
                    'average_score',
                    'meets_min_reviews',
                    'meets_min_score',
                    'can_approve',
                ],
            ],
        ]);
    }

    /** @test */
    public function admin_can_export_submissions_to_excel()
    {
        Excel::fake();

        InovChallengeSubmission::factory()->count(5)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.export'));

        $response->assertStatus(200);

        Excel::assertDownloaded('innovation_challenge_submissions_' . date('Y-m-d_His') . '.xlsx', function (InovChallengeSubmissionsExport $export) {
            return true;
        });
    }

    /** @test */
    public function admin_can_export_submissions_with_filters()
    {
        Excel::fake();

        InovChallengeSubmission::factory()->count(3)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'final_status' => 'approved',
        ]);

        InovChallengeSubmission::factory()->count(2)->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'final_status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.submissions.export', [
                'session_id' => $this->session->id,
                'status' => 'approved',
            ]));

        $response->assertStatus(200);

        Excel::assertDownloaded(function ($filename) {
            return str_contains($filename, 'innovation_challenge_submissions')
                && str_contains($filename, 'session_' . $this->session->id);
        });
    }

    /** @test */
    public function phase_2_cannot_be_approved_without_phase_1_approval()
    {
        config(['inov_challenge.require_sequential_phases' => true]);

        $submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->dosen->id,
            'phase_1_status' => 'submitted', // Not approved
            'phase_2_status' => 'reviewed',
        ]);

        // Create reviews for phase 2
        $reviewer1 = User::factory()->create(['role' => 'reviewer_inovchalange']);
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer1->id,
            'phase' => 'phase_2',
            'score' => 85,
            'status' => 'completed',
        ]);

        InovChallengeReview::factory()->create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_2',
            'score' => 80,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.submissions.approve', ['submission' => $submission, 'phase' => 'phase_2']));

        $response->assertSessionHas('error');

        $submission->refresh();
        $this->assertEquals('reviewed', $submission->phase_2_status);
    }
}
