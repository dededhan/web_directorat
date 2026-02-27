# Innovation Challenge Form Validation

## Overview

Dynamic form validation based on JSON configuration stored in the `inov_challenge_form_builders` table.

## Service Location

`App\Services\InovChallengeFormValidationService`

## Features

- ✅ Generate Laravel validation rules from JSON config
- ✅ Support for 9 field types (text, textarea, number, email, date, select, radio, checkbox, file)
- ✅ Dynamic required/optional field handling
- ✅ File upload validation (extensions, size limits, multiple files)
- ✅ Select/radio/checkbox options validation
- ✅ Custom error messages in Indonesian
- ✅ Field-specific validation helper methods

---

## Usage Examples

### 1. Basic Validation in Controller

```php
use App\Services\InovChallengeFormValidationService;
use App\Models\InovChallengeFormBuilder;

class ParticipantSubmissionController extends Controller
{
    protected $validationService;

    public function __construct(InovChallengeFormValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function store(Request $request, $sessionId, $phase)
    {
        // Get form configuration for the phase
        $form = InovChallengeFormBuilder::where('session_id', $sessionId)
            ->where('phase', $phase)
            ->firstOrFail();

        // Validate submission data
        try {
            $validatedData = $this->validationService->validateSubmissionData(
                $request->all(),
                $form->form_config
            );

            // Process validated data
            // ...

            return redirect()->back()->with('success', 'Submission berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
}
```

---

### 2. Using FormBuilderController Helper

```php
use App\Http\Controllers\InovChallenge\Admin\InovChallengeFormBuilderController;
use App\Models\InovChallengeFormBuilder;

// Get form
$form = InovChallengeFormBuilder::find($formId);

// Validate using controller helper
$formController = app(InovChallengeFormBuilderController::class);
$validatedData = $formController->validateSubmissionData($request->all(), $form);
```

---

### 3. Get Validation Rules Without Validating

```php
// Useful for JavaScript validation or displaying requirements to users
$validationService = app(InovChallengeFormValidationService::class);

$rules = $validationService->getRules($form->form_config);
// Returns: ['title' => 'required|string|max:255', 'email' => 'required|email|max:255', ...]

$messages = $validationService->getMessages($form->form_config);
// Returns: ['title.required' => 'Judul Proposal wajib diisi.', ...]

$attributes = $validationService->getAttributes($form->form_config);
// Returns: ['title' => 'Judul Proposal', 'email' => 'Email', ...]
```

---

### 4. Validate Specific Fields Only

```php
// Useful for multi-step forms or AJAX validation
$validatedData = $validationService->validateSpecificFields(
    $request->all(),
    $form->form_config,
    ['title', 'abstract'] // Only validate these fields
);
```

---

### 5. Check Field Requirements

```php
// Check if a field is required
$isRequired = $validationService->isFieldRequired($form->form_config, 'title');

// Get all required field names
$requiredFields = $validationService->getRequiredFields($form->form_config);
// Returns: ['title', 'abstract', 'background', ...]

// Get specific field configuration
$fieldConfig = $validationService->getFieldConfig($form->form_config, 'title');
// Returns: ['name' => 'title', 'label' => 'Judul Proposal', 'type' => 'text', 'required' => true, ...]
```

---

## Validation Rules by Field Type

### Text

```php
['name' => 'title', 'type' => 'text', 'required' => true]
// Generates: 'required|string|max:255'
```

### Textarea

```php
['name' => 'description', 'type' => 'textarea', 'required' => true]
// Generates: 'required|string|max:65535'
```

### Number

```php
['name' => 'amount', 'type' => 'number', 'required' => true]
// Generates: 'required|numeric'
```

### Email

```php
['name' => 'contact_email', 'type' => 'email', 'required' => true]
// Generates: 'required|email|max:255'
```

### Date

```php
['name' => 'start_date', 'type' => 'date', 'required' => true]
// Generates: 'required|date'
```

### Select / Radio

```php
[
    'name' => 'innovation_type',
    'type' => 'select',
    'required' => true,
    'options' => [
        'product' => 'Produk',
        'service' => 'Layanan',
        'process' => 'Proses'
    ]
]
// Generates: 'required|in:product,service,process'
```

### Checkbox (Multiple)

```php
[
    'name' => 'sdg_goals',
    'type' => 'checkbox',
    'required' => false,
    'options' => [
        'goal_1' => 'No Poverty',
        'goal_2' => 'Zero Hunger',
        'goal_3' => 'Good Health'
    ]
]
// Generates:
// 'sdg_goals' => 'nullable|array'
// 'sdg_goals.*' => 'in:goal_1,goal_2,goal_3'
```

### File (Single)

```php
[
    'name' => 'proposal_document',
    'type' => 'file',
    'required' => true,
    'accept' => '.pdf,.doc,.docx',
    'max_size' => 10240 // KB
]
// Generates: 'required|file|max:10240|mimes:pdf,doc,docx'
```

### File (Multiple)

```php
[
    'name' => 'supporting_documents',
    'type' => 'file',
    'required' => false,
    'accept' => '.pdf,.jpg,.png',
    'max_size' => 5120,
    'multiple' => true
]
// Generates:
// 'supporting_documents' => 'array'
// 'supporting_documents.*' => 'nullable|file|max:5120|mimes:pdf,jpg,png'
```

---

## Debug Endpoint

View generated validation rules for a form (only available when `APP_DEBUG=true`):

```
GET /admin/inov-challenge/sessions/{session}/forms/{form}/validation-rules
```

Response:

```json
{
    "phase": "phase_1",
    "form_config": [...],
    "validation_rules": {
        "title": "required|string|max:255",
        "abstract": "required|string|max:65535",
        "proposal_document": "required|file|max:10240|mimes:pdf,doc,docx"
    },
    "validation_messages": {
        "title.required": "Judul Proposal wajib diisi.",
        "abstract.required": "Abstract wajib diisi."
    },
    "validation_attributes": {
        "title": "Judul Proposal",
        "abstract": "Abstract"
    },
    "required_fields": ["title", "abstract", "proposal_document"]
}
```

---

## Error Messages

All error messages are in Indonesian by default:

- Required fields: `{label} wajib diisi.`
- Email: Standard Laravel email validation
- File size: `The {label} must not be greater than {size} kilobytes.`
- File type: `The {label} must be a file of type: {types}.`
- Select/radio options: `The selected {label} is invalid.`

---

## Best Practices

1. **Always validate on the server side** even if you have client-side validation
2. **Use the service in controllers** for consistent validation across the application
3. **Handle file uploads separately** using Laravel's `storeAs()` or `store()` methods after validation
4. **Cache validation rules** if you're validating multiple submissions against the same form
5. **Use specific field validation** for AJAX or multi-step forms to improve UX

---

## Form Config Example

Complete example from `phase_1` default fields:

```json
[
    {
        "name": "title",
        "label": "Judul Proposal",
        "type": "text",
        "required": true,
        "placeholder": "Masukkan judul innovation challenge"
    },
    {
        "name": "abstract",
        "label": "Abstract",
        "type": "textarea",
        "required": true,
        "placeholder": "Tuliskan abstract proposal Anda",
        "rows": 5
    },
    {
        "name": "innovation_type",
        "label": "Jenis Inovasi",
        "type": "select",
        "required": true,
        "options": {
            "product": "Produk",
            "service": "Layanan",
            "process": "Proses",
            "technology": "Teknologi"
        }
    },
    {
        "name": "proposal_document",
        "label": "Dokumen Proposal",
        "type": "file",
        "required": true,
        "accept": ".pdf,.doc,.docx",
        "max_size": 10240
    }
]
```

Generated validation rules:

```php
[
    'title' => 'required|string|max:255',
    'abstract' => 'required|string|max:65535',
    'innovation_type' => 'required|in:product,service,process,technology',
    'proposal_document' => 'required|file|max:10240|mimes:pdf,doc,docx'
]
```

---

## Integration with Sprint 3 (Participant Module)

When implementing the participant submission controller in Sprint 3:

1. Inject `InovChallengeFormValidationService` in constructor
2. Get active session and phase form configuration
3. Validate user input using `validateSubmissionData()`
4. Handle file uploads after validation
5. Store submission data in `inov_challenge_submissions` table

Example:

```php
public function submitPhase(Request $request, $phase)
{
    $activeSession = InovChallengeSession::where('status', 'active')->firstOrFail();
    $form = $activeSession->getFormByPhase($phase);

    // Validate
    $validated = $this->validationService->validateSubmissionData(
        $request->except('_token'),
        $form->form_config
    );

    // Handle files
    foreach ($form->form_config as $field) {
        if ($field['type'] === 'file' && $request->hasFile($field['name'])) {
            $path = $request->file($field['name'])->store('submissions/' . $phase);
            $validated[$field['name']] = $path;
        }
    }

    // Save submission
    $submission = InovChallengeSubmission::updateOrCreate(
        ['user_id' => auth()->id(), 'session_id' => $activeSession->id],
        [$phase . '_data' => $validated, $phase . '_status' => 'submitted']
    );

    return redirect()->back()->with('success', 'Submission berhasil disimpan.');
}
```

---

## Testing

To test the validation service:

```php
// tests/Unit/InovChallengeFormValidationServiceTest.php

use Tests\TestCase;
use App\Services\InovChallengeFormValidationService;

class InovChallengeFormValidationServiceTest extends TestCase
{
    public function test_generates_rules_for_required_text_field()
    {
        $service = new InovChallengeFormValidationService();

        $formConfig = [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true]
        ];

        $rules = $service->getRules($formConfig);

        $this->assertEquals('required|string|max:255', $rules['title']);
    }

    // Add more tests for each field type...
}
```

---

## Summary

The Innovation Challenge Form Validation system provides:

- **Flexibility**: Forms can be customized per session without code changes
- **Consistency**: Single source of truth for validation rules
- **Maintainability**: Validation logic centralized in one service
- **Developer-friendly**: Easy to use helper methods and clear documentation
- **User-friendly**: Indonesian error messages and descriptive field names

This system will be heavily used in Sprint 3 (Participant Module) and Sprint 5 (Reviewer Module).
