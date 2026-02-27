<?php

namespace Tests\Feature\InovChallenge\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeReview;
use App\Models\InovChallengeTeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class InovChallengeReviewerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $reviewer;
    protected $participant;
    protected $session;
    protected $submission;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::factory()->create(['role' => 'inovchalange']);
        $this->reviewer = User::factory()->create(['role' => 'reviewer_inovchalange']);
        $this->participant = User::factory()->create(['role' => 'dosen']);

        // Create active session
        $this->session = InovChallengeSession::factory()->create([
            'status' => 'active',
        ]);

        // Create submitted submission
        $this->submission = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->participant->id,
            'phase_1_status' => 'submitted',
            'phase_1_data' => ['project_title' => 'Test Project'],
        ]);
    }

    /** @test */
    public function admin_can_view_reviewer_assignment_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.reviewers.show_assign_form'));

        $response->assertStatus(200);
        $response->assertViewIs('inov_challenge.admin.reviewers.assign');
        $response->assertViewHas('submissions');
        $response->assertViewHas('reviewers');
        $response->assertViewHas('reviewerWorkload');
    }

    /** @test */
    public function non_admin_cannot_view_reviewer_assignment_form()
    {
        $response = $this->actingAs($this->participant)
            ->get(route('admin.inov_challenge.reviewers.show_assign_form'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_specific_submission_in_assignment_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.reviewers.show_assign_form', [
                'submission' => $this->submission->id,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('selectedSubmission', function ($submission) {
            return $submission->id === $this->submission->id;
        });
    }

    /** @test */
    public function admin_can_assign_reviewer_to_submission()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $this->reviewer->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inov_challenge_reviews', [
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
        ]);

        // Verify submission status updated to under_review
        $this->submission->refresh();
        $this->assertEquals('under_review', $this->submission->phase_1_status);
    }

    /** @test */
    public function admin_cannot_assign_non_reviewer_user()
    {
        $nonReviewer = User::factory()->create(['role' => 'dosen']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $nonReviewer->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('inov_challenge_reviews', [
            'submission_id' => $this->submission->id,
            'reviewer_id' => $nonReviewer->id,
        ]);
    }

    /** @test */
    public function admin_cannot_assign_reviewer_to_draft_phase()
    {
        $this->submission->update(['phase_1_status' => 'draft']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $this->reviewer->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('inov_challenge_reviews', [
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
        ]);
    }

    /** @test */
    public function admin_cannot_assign_same_reviewer_twice_to_same_phase()
    {
        // Assign reviewer first time
        InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        // Try to assign same reviewer again
        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $this->reviewer->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        // Verify only one review exists
        $this->assertEquals(1, InovChallengeReview::where([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
        ])->count());
    }

    /** @test */
    public function admin_cannot_assign_submission_creator_as_reviewer()
    {
        // Give submission creator reviewer role (conflict of interest)
        $this->participant->update(['role' => 'reviewer_inovchalange']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $this->participant->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('inov_challenge_reviews', [
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->participant->id,
        ]);
    }

    /** @test */
    public function admin_cannot_assign_team_member_as_reviewer()
    {
        $teamMember = User::factory()->create(['role' => 'reviewer_inovchalange']);

        // Add as team member
        InovChallengeTeamMember::create([
            'submission_id' => $this->submission->id,
            'user_id' => $teamMember->id,
            'name' => $teamMember->name,
            'email' => $teamMember->email,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.inov_challenge.reviewers.assign'), [
                'submission_id' => $this->submission->id,
                'reviewer_id' => $teamMember->id,
                'phase' => 'phase_1',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('inov_challenge_reviews', [
            'submission_id' => $this->submission->id,
            'reviewer_id' => $teamMember->id,
        ]);
    }

    /** @test */
    public function admin_can_remove_assigned_reviewer()
    {
        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $this->submission->update(['phase_1_status' => 'under_review']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.reviewers.remove', $review));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('inov_challenge_reviews', [
            'id' => $review->id,
        ]);

        // Verify submission status changed back to submitted (no other reviewers)
        $this->submission->refresh();
        $this->assertEquals('submitted', $this->submission->phase_1_status);
    }

    /** @test */
    public function admin_cannot_remove_completed_reviewer()
    {
        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'completed',
            'assigned_at' => now(),
            'reviewed_at' => now(),
            'score' => 85,
            'feedback' => 'Good work',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.reviewers.remove', $review));

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('inov_challenge_reviews', [
            'id' => $review->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function submission_stays_under_review_when_removing_one_of_multiple_reviewers()
    {
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        // Assign two reviewers
        $review1 = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $this->submission->update(['phase_1_status' => 'under_review']);

        // Remove first reviewer
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.inov_challenge.reviewers.remove', $review1));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verify submission still under_review (reviewer2 still assigned)
        $this->submission->refresh();
        $this->assertEquals('under_review', $this->submission->phase_1_status);
    }

    /** @test */
    public function admin_can_reassign_review_to_different_reviewer()
    {
        $newReviewer = User::factory()->create(['role' => 'reviewer_inovchalange']);

        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'in_progress',
            'assigned_at' => now(),
            'score' => 75,
            'feedback' => 'Initial feedback',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review), [
                'new_reviewer_id' => $newReviewer->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $review->refresh();
        $this->assertEquals($newReviewer->id, $review->reviewer_id);
        $this->assertEquals('assigned', $review->status);
        $this->assertNull($review->score);
        $this->assertNull($review->feedback);
    }

    /** @test */
    public function admin_cannot_reassign_completed_review()
    {
        $newReviewer = User::factory()->create(['role' => 'reviewer_inovchalange']);

        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'completed',
            'assigned_at' => now(),
            'reviewed_at' => now(),
            'score' => 85,
            'feedback' => 'Good work',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review), [
                'new_reviewer_id' => $newReviewer->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $review->refresh();
        $this->assertEquals($this->reviewer->id, $review->reviewer_id);
    }

    /** @test */
    public function admin_cannot_reassign_to_same_reviewer()
    {
        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review), [
                'new_reviewer_id' => $this->reviewer->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_cannot_reassign_to_already_assigned_reviewer()
    {
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        // Reviewer 1 assigned
        $review1 = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        // Reviewer 2 already assigned to same submission/phase
        InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $reviewer2->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        // Try to reassign review1 to reviewer2 (already assigned)
        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review1), [
                'new_reviewer_id' => $reviewer2->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $review1->refresh();
        $this->assertEquals($this->reviewer->id, $review1->reviewer_id);
    }

    /** @test */
    public function admin_cannot_reassign_to_submission_creator()
    {
        // Give participant reviewer role
        $this->participant->update(['role' => 'reviewer_inovchalange']);

        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review), [
                'new_reviewer_id' => $this->participant->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $review->refresh();
        $this->assertEquals($this->reviewer->id, $review->reviewer_id);
    }

    /** @test */
    public function admin_cannot_reassign_to_team_member()
    {
        $teamMember = User::factory()->create(['role' => 'reviewer_inovchalange']);

        // Add as team member
        InovChallengeTeamMember::create([
            'submission_id' => $this->submission->id,
            'user_id' => $teamMember->id,
            'name' => $teamMember->name,
            'email' => $teamMember->email,
            'status' => 'accepted',
        ]);

        $review = InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.inov_challenge.reviewers.reassign', $review), [
                'new_reviewer_id' => $teamMember->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        $review->refresh();
        $this->assertEquals($this->reviewer->id, $review->reviewer_id);
    }

    /** @test */
    public function reviewer_workload_is_calculated_correctly()
    {
        $reviewer2 = User::factory()->create(['role' => 'reviewer_inovchalange']);

        // Create reviews for reviewer 1
        InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        InovChallengeReview::create([
            'submission_id' => $this->submission->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_2',
            'status' => 'in_progress',
            'assigned_at' => now(),
        ]);

        $submission2 = InovChallengeSubmission::factory()->create([
            'session_id' => $this->session->id,
            'user_id' => $this->participant->id,
            'phase_1_status' => 'submitted',
        ]);

        InovChallengeReview::create([
            'submission_id' => $submission2->id,
            'reviewer_id' => $this->reviewer->id,
            'phase' => 'phase_1',
            'status' => 'completed',
            'assigned_at' => now(),
            'reviewed_at' => now(),
            'score' => 80,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.inov_challenge.reviewers.show_assign_form'));

        $response->assertStatus(200);
        $response->assertViewHas('reviewerWorkload', function ($workload) {
            return $workload[$this->reviewer->id]['active'] === 2 // assigned + in_progress
                && $workload[$this->reviewer->id]['completed'] === 1
                && $workload[$this->reviewer->id]['total'] === 3;
        });
    }
}
