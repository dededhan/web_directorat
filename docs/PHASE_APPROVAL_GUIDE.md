# Innovation Challenge Phase Approval Logic

## Overview

The phase approval system manages the sequential progression of submissions through three phases (Phase 1, 2, 3) with comprehensive validation, scoring, and automatic phase unlocking.

## Files Modified

- `app/Http/Controllers/InovChallenge/Admin/InovChallengeSubmissionController.php`
- `routes/inovchalange.php`

---

## Key Features

✅ **Score Validation** - Checks if average score meets minimum threshold before approval  
✅ **Sequential Phase Progression** - Ensures previous phases are approved before proceeding  
✅ **Minimum Review Validation** - Requires minimum number of reviewers per phase  
✅ **Auto-unlock Next Phase** - Automatically unlocks next phase upon approval (configurable)  
✅ **Status Management** - Proper final_status updates based on phase and decision  
✅ **Notifications** - Sends notifications to submission owner and team members  
✅ **Manual Phase Unlock** - Admin can manually unlock phases if needed  
✅ **Email Notifications** - Placeholder for email notifications (Sprint 7)

---

## Configuration Settings

All settings are in `config/inov_challenge.php`:

```php
// Require approval of previous phase before submitting to next phase
'require_sequential_phases' => env('INOV_CHALLENGE_SEQUENTIAL_PHASES', true),

// Automatically unlock next phase upon approval
'auto_unlock_next_phase' => env('INOV_CHALLENGE_AUTO_UNLOCK_PHASE', true),

// Minimum number of reviewers required per submission phase
'min_reviewers_per_phase' => env('INOV_CHALLENGE_MIN_REVIEWERS', 2),

// Minimum score for phase approval
'min_score_for_approval' => env('INOV_CHALLENGE_MIN_SCORE', 70),

// Send notifications when phase is approved/rejected
'notify_phase_decision' => env('INOV_CHALLENGE_NOTIFY_PHASE_DECISION', true),
```

---

## Approval Workflow

### 1. Phase Approval Process

```
Submission → Reviews Completed → Status: 'reviewed' → Admin Approve → Phase Approved → Next Phase Unlocked
```

**Validation Checks Before Approval:**

1. ✅ Phase must be in 'reviewed' status
2. ✅ Previous phase must be approved (if sequential phases enabled)
3. ✅ Minimum number of reviews must be met
4. ✅ Average score must meet or exceed minimum threshold

**Example:**

```php
// Phase 1 Approval Requirements:
- phase_1_status = 'reviewed'
- Review count >= 2 (min_reviewers_per_phase)
- Average score >= 70 (min_score_for_approval)

// Phase 2 Approval Requirements:
- All Phase 1 requirements +
- phase_1_status = 'approved'

// Phase 3 Approval Requirements:
- All Phase 2 requirements +
- phase_2_status = 'approved'
```

---

### 2. Phase Rejection Process

```
Submission → Reviews Completed → Status: 'reviewed' → Admin Reject → Phase Rejected → Notify User
```

**Rejection Behavior:**

- **Phase 1 Rejection**: `final_status` = `'rejected'` (full rejection)
- **Phase 2/3 Rejection**: `final_status` = `'needs_revision'` (allow resubmission)

**Validation:**

- Rejection reason must be at least 10 characters
- Phase must be in 'submitted', 'under_review', or 'reviewed' status

---

## API Endpoints

### 1. Approve Phase

**POST** `/admin/inov-challenge/submissions/{submission}/approve/{phase}`

Approves a submission for a specific phase.

**Parameters:**

- `{submission}` - Submission ID
- `{phase}` - Phase name (`phase_1`, `phase_2`, or `phase_3`)

**Response:**

```json
{
    "success": "Submission untuk phase_1 berhasil disetujui. phase_2 telah dibuka."
}
```

**Errors:**

```json
{
    "error": "Phase 1 harus disetujui terlebih dahulu sebelum menyetujui Phase 2."
}
{
    "error": "Minimum 2 reviewer diperlukan untuk menyetujui phase ini. Saat ini: 1 reviewer."
}
{
    "error": "Rata-rata score (65) belum mencapai minimum score untuk approval (70)."
}
```

---

### 2. Reject Phase

**POST** `/admin/inov-challenge/submissions/{submission}/reject/{phase}`

Rejects a submission for a specific phase.

**Request Body:**

```json
{
    "rejection_reason": "Proposal kurang detail dan tidak sesuai dengan tema innovation challenge."
}
```

**Response:**

```json
{
    "success": "Submission untuk phase_1 berhasil ditolak."
}
```

---

### 3. Manually Unlock Phase

**POST** `/admin/inov-challenge/submissions/{submission}/unlock/{phase}`

Manually unlocks a phase for a submission (useful when auto-unlock is disabled).

**Response:**

```json
{
    "success": "phase_2 berhasil dibuka."
}
```

---

### 4. Get Phase Status

**GET** `/admin/inov-challenge/submissions/{submission}/phase-status`

Returns detailed status for all phases including approval readiness.

**Response:**

```json
{
    "submission_id": 123,
    "final_status": "in_progress",
    "phases": {
        "phase_1": {
            "status": "approved",
            "review_count": 3,
            "average_score": 85.5,
            "meets_min_reviews": true,
            "meets_min_score": true,
            "can_approve": false
        },
        "phase_2": {
            "status": "reviewed",
            "review_count": 2,
            "average_score": 72.0,
            "meets_min_reviews": true,
            "meets_min_score": true,
            "can_approve": true
        },
        "phase_3": {
            "status": "draft",
            "review_count": 0,
            "average_score": null,
            "meets_min_reviews": false,
            "meets_min_score": false,
            "can_approve": false
        }
    }
}
```

---

## Phase Status Flow

### Phase Status Values

| Status         | Description                                     |
| -------------- | ----------------------------------------------- |
| `null`         | Phase not yet accessible                        |
| `locked`       | Phase locked (previous phase not approved)      |
| `draft`        | Phase unlocked, can be edited                   |
| `submitted`    | Phase submitted, waiting for review assignment  |
| `under_review` | Reviews in progress                             |
| `reviewed`     | All reviews completed, ready for admin decision |
| `approved`     | Phase approved by admin                         |
| `rejected`     | Phase rejected by admin                         |

### Final Status Values

| Status           | Description                                      |
| ---------------- | ------------------------------------------------ |
| `draft`          | Initial submission, no phases submitted          |
| `in_progress`    | At least one phase approved, more phases pending |
| `needs_revision` | Phase 2 or 3 rejected, can revise and resubmit   |
| `rejected`       | Phase 1 rejected or permanently rejected         |
| `approved`       | Phase 3 approved, submission complete            |

---

## Usage Examples

### Example 1: Approve Phase 1

```php
// In admin panel submission detail page
// Click "Approve Phase 1" button

// System checks:
1. phase_1_status == 'reviewed' ✅
2. Review count: 3 >= 2 ✅
3. Average score: 85 >= 70 ✅

// System actions:
1. Update phase_1_status = 'approved'
2. Update final_status = 'in_progress'
3. If auto_unlock enabled: phase_2_status = 'draft'
4. Notify user and team members
5. Display: "Submission untuk phase_1 berhasil disetujui. phase_2 telah dibuka."
```

---

### Example 2: Reject Phase 2

```php
// Admin enters rejection reason
$rejectionReason = "Rencana implementasi kurang detail dan timeline tidak realistis.";

// System checks:
1. phase_2_status in ['submitted', 'under_review', 'reviewed'] ✅

// System actions:
1. Update phase_2_status = 'rejected'
2. Update final_status = 'needs_revision' (not 'rejected' because it's Phase 2)
3. Notify user with rejection reason
4. Notify team members
```

---

### Example 3: Sequential Phase Validation

```php
// User tries to submit Phase 2 while Phase 1 is still in review

if (config('inov_challenge.require_sequential_phases')) {
    if (!$submission->isPhaseApproved('phase_1')) {
        // Blocked! Cannot submit Phase 2 yet
        return "Phase 1 harus disetujui terlebih dahulu.";
    }
}
```

---

### Example 4: Manual Phase Unlock

```php
// Admin wants to unlock Phase 2 manually (skipping Phase 1 approval)
// Useful for testing or special circumstances

POST /admin/inov-challenge/submissions/123/unlock/phase_2

// System actions:
1. Update phase_2_status = 'draft'
2. Notify user: "phase_2 telah dibuka secara manual oleh admin"
```

---

## Notifications

### Approval Notification

```
Subject: Phase Approved - Innovation Challenge

Submission Anda untuk phase_1 telah disetujui oleh admin dengan rata-rata score 85.5.
Phase selanjutnya (phase_2) telah dibuka dan siap untuk diisi.
```

### Rejection Notification

```
Subject: Phase Rejected - Innovation Challenge

Submission Anda untuk phase_1 ditolak.

Alasan: Proposal kurang detail dan tidak sesuai dengan tema innovation challenge.

Silakan perbaiki dan submit ulang.
```

### Phase Unlocked Notification

```
Subject: Phase Unlocked - Innovation Challenge

phase_2 telah dibuka dan siap untuk diisi.
Segera lengkapi form untuk melanjutkan ke tahap selanjutnya.
```

---

## Helper Methods

### Model Methods (InovChallengeSubmission)

```php
// Check if a phase is approved
$submission->isPhaseApproved('phase_1'); // returns bool

// Get average score for a phase
$submission->getAverageScoreForPhase('phase_1'); // returns float

// Get reviews for a specific phase
$submission->reviewsByPhase('phase_1'); // returns Collection

// Get current active phase
$submission->getCurrentPhase(); // returns 'phase_1', 'phase_2', 'phase_3', or 'completed'

// Check if user can edit a phase
$submission->canEditPhase('phase_1'); // returns bool (true if status is 'draft' or 'rejected')
```

### Controller Helper Methods

```php
// Get next phase
$this->getNextPhase('phase_1'); // returns 'phase_2'

// Unlock next phase after approval
$this->unlockNextPhase($submission, 'phase_1');

// Send email notifications (placeholder for Sprint 7)
$this->sendApprovalNotification($submission, $phase, $score);
$this->sendRejectionNotification($submission, $phase, $reason);
```

---

## Configuration Scenarios

### Scenario 1: Strict Sequential + Manual Unlock

```env
INOV_CHALLENGE_SEQUENTIAL_PHASES=true
INOV_CHALLENGE_AUTO_UNLOCK_PHASE=false
```

**Behavior:**

- Users MUST complete phases in order (1 → 2 → 3)
- Admin must manually unlock each phase after approval
- Use case: Strict milestone-based progression with admin control

---

### Scenario 2: Sequential + Auto Unlock (Default)

```env
INOV_CHALLENGE_SEQUENTIAL_PHASES=true
INOV_CHALLENGE_AUTO_UNLOCK_PHASE=true
```

**Behavior:**

- Users MUST complete phases in order (1 → 2 → 3)
- Next phase automatically unlocks upon approval
- Use case: Standard competition workflow with automatic progression

---

### Scenario 3: Non-Sequential + Auto Unlock

```env
INOV_CHALLENGE_SEQUENTIAL_PHASES=false
INOV_CHALLENGE_AUTO_UNLOCK_PHASE=true
```

**Behavior:**

- Users can work on any phase independently
- All phases unlocked from the start
- Use case: Flexible submission where phases are independent modules

---

## Testing Checklist

### Unit Tests

- [ ] Approve phase with sufficient reviews and score
- [ ] Block approval with insufficient reviews
- [ ] Block approval with low score
- [ ] Block Phase 2 approval without Phase 1 approval
- [ ] Block Phase 3 approval without Phase 2 approval
- [ ] Test auto-unlock next phase on approval
- [ ] Test manual phase unlock
- [ ] Test rejection with valid reason
- [ ] Test rejection reason validation (min 10 chars)
- [ ] Test final_status updates for each phase
- [ ] Test notification creation

### Integration Tests

- [ ] Full workflow: Submit → Review → Approve → Auto-unlock → Submit Next Phase
- [ ] Sequential phase validation in participant controller
- [ ] Phase status API returns correct data
- [ ] Email notifications sent (when Sprint 7 implemented)

---

## Future Enhancements (Post-Sprint 2)

1. **Sprint 3**: Integrate with participant submission controller
2. **Sprint 5**: Reviewer can see approval requirements in review interface
3. **Sprint 7**: Implement actual email notifications
4. **Sprint 7**: Add SMS notifications for critical status changes
5. **Sprint 8**: Admin dashboard showing approval bottlenecks

---

## Troubleshooting

### "Submission hanya dapat disetujui setelah direview"

**Cause:** Phase status is not 'reviewed'  
**Solution:** Ensure all assigned reviewers have completed their reviews. Status progression: `submitted` → `under_review` → `reviewed` → `approved`

---

### "Minimum X reviewer diperlukan untuk menyetujui phase ini"

**Cause:** Not enough reviewers assigned or completed reviews  
**Solution:**

1. Assign more reviewers to the submission
2. Wait for existing reviewers to complete reviews
3. Or adjust `INOV_CHALLENGE_MIN_REVIEWERS` in config (not recommended)

---

### "Rata-rata score (X) belum mencapai minimum score untuk approval (Y)"

**Cause:** Average review score below threshold  
**Solution:**

1. Request reviewers to reassess (if they made errors)
2. Reject the phase and ask participant to improve
3. Or adjust `INOV_CHALLENGE_MIN_SCORE` in config (must be justified)

---

### "Phase X harus disetujui terlebih dahulu"

**Cause:** Trying to approve a phase while previous phase is not approved  
**Solution:**

1. Approve previous phases first (proper sequence)
2. Or use manual unlock if justified
3. Or disable sequential phases (not recommended for competitions)

---

## Summary

The phase approval system provides:

✅ **Robust Validation** - Multiple checks before approval  
✅ **Flexible Configuration** - Adapt to different competition styles  
✅ **Automatic Progression** - Reduces admin workload  
✅ **Clear Communication** - Notifications keep participants informed  
✅ **Admin Control** - Manual overrides when needed  
✅ **Audit Trail** - All actions logged via notifications

This system ensures fair, transparent, and efficient progression through the Innovation Challenge phases.
