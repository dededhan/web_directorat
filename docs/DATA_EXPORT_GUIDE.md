# Innovation Challenge Data Export

## Overview
Comprehensive Excel export functionality for Innovation Challenge submissions with multiple sheets, advanced filtering, and professional formatting.

## Files
- `app/Exports/InovChallengeSubmissionsExport.php` - Main export class with multi-sheet support
- `app/Http/Controllers/InovChallenge/Admin/InovChallengeSubmissionController.php` - Export endpoint

---

## Features

✅ **Multi-Sheet Export** - Submissions, Team Members, Reviews in separate sheets  
✅ **Advanced Filtering** - Session, status, phase, date range, search  
✅ **Professional Formatting** - Color-coded headers, auto-sized columns  
✅ **Config-Driven** - Include/exclude sheets based on configuration  
✅ **Comprehensive Data** - All submission details, scores, timestamps  
✅ **Dynamic Filename** - Reflects applied filters  

---

## Export Sheets

### Sheet 1: Submissions

**Contains:**
- Submission ID, Title, Session
- Team leader details (name, email, fakultas, prodi)
- Team member count
- Phase statuses (Phase 1, 2, 3)
- Phase submission dates
- Phase average scores
- Phase review counts
- Final status
- Timestamps (created, updated)

**Columns:** 23 columns  
**Header Color:** Blue (`#4472C4`)  
**Sort Order:** Created date descending

---

### Sheet 2: Team Members

**Contains:**
- Submission ID and title
- Team leader name
- Member details (name, email, type, role)
- Invitation status
- Joined date

**Columns:** 9 columns  
**Header Color:** Green (`#70AD47`)  
**Configurable:** Can be disabled via `INOV_CHALLENGE_EXPORT_TEAM_MEMBERS=false`

---

### Sheet 3: Reviews

**Contains:**
- Submission ID and title
- Team leader name
- Phase
- Reviewer details (name, email)
- Score and comments
- Review status
- Reviewed date

**Columns:** 10 columns  
**Header Color:** Orange (`#FFC000`)  
**Configurable:** Can be disabled via `INOV_CHALLENGE_EXPORT_REVIEWS=false`

---

## API Endpoint

### Export Submissions

**GET** `/admin/inov-challenge/submissions/export`

**Query Parameters:**

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `session_id` | integer | No | Filter by session ID |
| `status` | string | No | Filter by final status (`draft`, `submitted`, `approved`, etc.) |
| `phase` | string | No | Filter by phase (`phase_1`, `phase_2`, `phase_3`) |
| `date_from` | date | No | Filter submissions from this date (Y-m-d) |
| `date_to` | date | No | Filter submissions to this date (Y-m-d) |
| `search` | string | No | Search in title, team leader name, or email |

**Example Requests:**

```bash
# Export all submissions
GET /admin/inov-challenge/submissions/export

# Export submissions for specific session
GET /admin/inov-challenge/submissions/export?session_id=5

# Export approved submissions only
GET /admin/inov-challenge/submissions/export?status=approved

# Export Phase 1 submissions
GET /admin/inov-challenge/submissions/export?phase=phase_1

# Export with date range
GET /admin/inov-challenge/submissions/export?date_from=2026-01-01&date_to=2026-03-31

# Export with search
GET /admin/inov-challenge/submissions/export?search=innovation

# Combine multiple filters
GET /admin/inov-challenge/submissions/export?session_id=5&status=approved&phase=phase_3
```

**Response:**
- Downloads an Excel file (.xlsx)
- Filename format: `innovation_challenge_submissions_YYYY-MM-DD_HHmmss[_filters].xlsx`
- Examples:
  - `innovation_challenge_submissions_2026-02-27_143021.xlsx`
  - `innovation_challenge_submissions_2026-02-27_143021_session_5.xlsx`
  - `innovation_challenge_submissions_2026-02-27_143021_session_5_phase_1_approved.xlsx`

---

## Configuration

### Environment Variables

```env
# Include team members sheet in export
INOV_CHALLENGE_EXPORT_TEAM_MEMBERS=true

# Include reviews sheet in export
INOV_CHALLENGE_EXPORT_REVIEWS=true
```

### Config File (`config/inov_challenge.php`)

```php
// Include team member details in exports
'export_include_team_members' => env('INOV_CHALLENGE_EXPORT_TEAM_MEMBERS', true),

// Include review comments in exports
'export_include_reviews' => env('INOV_CHALLENGE_EXPORT_REVIEWS', true),
```

---

## Column Details

### Submissions Sheet Columns

| Column | Width | Description |
|--------|-------|-------------|
| A - ID | 8 | Submission ID |
| B - Session | 25 | Session title |
| C - Judul | 35 | Submission title |
| D - Ketua Tim | 25 | Team leader name |
| E - Email Ketua | 30 | Team leader email |
| F - Fakultas | 20 | Faculty |
| G - Prodi | 30 | Study program |
| H - Jumlah Anggota | 15 | Team member count |
| I - Phase 1 Status | 18 | Phase 1 status |
| J - Phase 1 Submitted | 18 | Phase 1 submission date |
| K - Phase 1 Score | 12 | Phase 1 average score |
| L - Phase 1 Reviews | 12 | Phase 1 review count |
| M - Phase 2 Status | 18 | Phase 2 status |
| N - Phase 2 Submitted | 18 | Phase 2 submission date |
| O - Phase 2 Score | 12 | Phase 2 average score |
| P - Phase 2 Reviews | 12 | Phase 2 review count |
| Q - Phase 3 Status | 18 | Phase 3 status |
| R - Phase 3 Submitted | 18 | Phase 3 submission date |
| S - Phase 3 Score | 12 | Phase 3 average score |
| T - Phase 3 Reviews | 12 | Phase 3 review count |
| U - Final Status | 18 | Final submission status |
| V - Created At | 18 | Creation timestamp |
| W - Updated At | 18 | Last update timestamp |

---

## Status Mapping

Export uses human-readable status labels:

| Database Value | Export Label |
|----------------|--------------|
| `draft` | Draft |
| `submitted` | Submitted |
| `under_review` | Under Review |
| `reviewed` | Reviewed |
| `approved` | Approved |
| `rejected` | Rejected |
| `in_progress` | In Progress |
| `needs_revision` | Needs Revision |
| `null` or empty | - |

---

## Score Formatting

- Scores are formatted with 2 decimal places
- Example: `85.50`, `72.33`, `90.00`
- Empty scores display as `-`

---

## Date Formatting

All dates are formatted as: `Y-m-d H:i`  
Example: `2026-02-27 14:30`

---

## Usage in Blade View

### Export Button

```blade
<!-- In resources/views/inov_challenge/admin/submissions/index.blade.php -->

<form action="{{ route('admin.inov_challenge.submissions.export') }}" method="GET" class="inline">
    <!-- Pass current filters -->
    @if(request('session_id'))
        <input type="hidden" name="session_id" value="{{ request('session_id') }}">
    @endif
    
    @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    
    @if(request('phase'))
        <input type="hidden" name="phase" value="{{ request('phase') }}">
    @endif
    
    @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    
    <button type="submit" class="btn btn-success">
        <i class='bx bx-download'></i>
        Export to Excel
    </button>
</form>
```

### Export with Date Range Filter

```blade
<div class="export-form">
    <form action="{{ route('admin.inov_challenge.submissions.export') }}" method="GET">
        <div class="form-row">
            <div class="col">
                <label>From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col">
                <label>To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col">
                <label>Session</label>
                <select name="session_id" class="form-control">
                    <option value="">All Sessions</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                            {{ $session->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-auto">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class='bx bx-download'></i> Export
                </button>
            </div>
        </div>
    </form>
</div>
```

---

## Controller Usage

### Export with Filters from Code

```php
use App\Exports\InovChallengeSubmissionsExport;
use Maatwebsite\Excel\Facades\Excel;

// Export approved submissions from specific session
$filters = [
    'session_id' => 5,
    'status' => 'approved',
];

return Excel::download(
    new InovChallengeSubmissionsExport($filters),
    'approved_submissions.xlsx'
);
```

### Export to Server Storage (Not Download)

```php
use App\Exports\InovChallengeSubmissionsExport;
use Maatwebsite\Excel\Facades\Excel;

// Store export on server
$filters = ['session_id' => 5];
$path = 'exports/submissions_' . date('Y-m-d_His') . '.xlsx';

Excel::store(
    new InovChallengeSubmissionsExport($filters),
    $path,
    'public'
);

// Get full path
$fullPath = storage_path('app/public/' . $path);
```

---

## Performance Considerations

### Large Datasets

For exports with thousands of records:

1. **Use Chunking** (if needed in future):
   ```php
   // Add to SubmissionsSheet class
   use Maatwebsite\Excel\Concerns\FromQuery;
   use Maatwebsite\Excel\Concerns\WithChunkReading;
   
   public function query()
   {
       return InovChallengeSubmission::query()->with(...);
   }
   
   public function chunkSize(): int
   {
       return 1000;
   }
   ```

2. **Queue Exports** (for very large datasets):
   ```php
   use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
   use Illuminate\Contracts\Queue\ShouldQueue;
   
   class InovChallengeSubmissionsExport implements WithMultipleSheets, ShouldQueue
   {
       // ...
   }
   
   // In controller
   return (new InovChallengeSubmissionsExport($filters))
       ->queue('innovation_challenge_export.xlsx')
       ->chain([
           // Send email notification when done
       ]);
   ```

### Current Implementation

- Uses `FromCollection` - loads all data into memory
- Suitable for up to ~10,000 submissions
- For larger datasets, implement chunking or queuing

---

## Styling Details

### Header Styles

All sheet headers use:
- **Bold font**, size 12
- **White text color** (`#FFFFFF`)
- **Colored background** (different per sheet)
- **Centered alignment** (horizontal and vertical)

### Sheet-Specific Colors

- **Submissions**: Blue (`#4472C4`) - Professional, primary data
- **Team Members**: Green (`#70AD47`) - Represents team/collaboration
- **Reviews**: Orange (`#FFC000`) - Warm color for feedback/evaluation

### Column Widths

All columns are auto-sized for optimal readability:
- ID columns: 8-12 pixels
- Short text: 15-20 pixels
- Medium text: 25-30 pixels
- Long text (titles, comments): 35-50 pixels
- Dates: 18 pixels

---

## Error Handling

### Export Validation Errors

```json
{
    "errors": {
        "session_id": ["The selected session id is invalid."],
        "status": ["The selected status is invalid."],
        "date_to": ["The date to must be a date after or equal to date from."]
    }
}
```

### Export Exceptions

```php
try {
    return Excel::download(...);
} catch (\Exception $e) {
    return back()->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
}
```

Common errors:
- **Memory limit exceeded**: Reduce dataset size or implement chunking
- **Timeout**: Increase PHP max_execution_time or use queued exports
- **Permission denied**: Check storage directory permissions

---

## Testing

### Manual Testing Checklist

- [ ] Export all submissions (no filters)
- [ ] Export with session filter
- [ ] Export with status filter
- [ ] Export with phase filter
- [ ] Export with date range
- [ ] Export with search term
- [ ] Export with multiple combined filters
- [ ] Verify all 3 sheets are present
- [ ] Verify data accuracy in each sheet
- [ ] Check formatting (colors, widths, alignment)
- [ ] Test with empty result set
- [ ] Test with large dataset (1000+ submissions)
- [ ] Verify filename reflects filters

### Unit Test Example

```php
// tests/Feature/InovChallengeExportTest.php

public function test_can_export_submissions()
{
    $admin = User::factory()->create(['role' => 'inovchalange']);
    $session = InovChallengeSession::factory()->create();
    $submissions = InovChallengeSubmission::factory()->count(5)->create([
        'session_id' => $session->id,
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.inov_challenge.submissions.export', [
            'session_id' => $session->id,
        ]));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $this->assertTrue(
        str_contains($response->headers->get('content-disposition'), 'innovation_challenge_submissions')
    );
}
```

---

## Future Enhancements

### Sprint 7 (Notification Module)

- [ ] Email notification when export completes (for queued exports)
- [ ] Export history tracking (who exported what, when)
- [ ] Scheduled exports (daily/weekly reports)

### Sprint 8 (Testing & Refinement)

- [ ] PDF export option
- [ ] CSV export option
- [ ] Custom column selection
- [ ] Export templates
- [ ] Chart/graph generation in Excel

---

## Troubleshooting

### "Column count mismatch" Error

**Cause:** `headings()` and `map()` return different number of items  
**Solution:** Ensure both methods return same number of elements

### "Memory limit exhausted" Error

**Cause:** Too many submissions loaded at once  
**Solution:**
1. Add filters to reduce dataset size
2. Increase PHP memory_limit in php.ini
3. Implement chunking (see Performance section)

### Empty Excel File

**Cause:** Query returns no results  
**Solution:** Check filters, verify test data exists

### Wrong Data in Columns

**Cause:** Order mismatch between `headings()` and `map()`  
**Solution:** Verify array order matches exactly

---

## Summary

The Innovation Challenge Data Export system provides:

✅ **Comprehensive Data** - All submission, team, and review information  
✅ **Flexible Filtering** - 6+ filter options, combinable  
✅ **Professional Output** - Multi-sheet, color-coded, formatted  
✅ **Easy Integration** - Simple controller method, Blade-ready  
✅ **Configurable** - Enable/disable sheets via config  
✅ **Performance-Ready** - Can handle thousands of records  

This export feature enables administrators to analyze Innovation Challenge data in Excel for reporting, analysis, and decision-making.
