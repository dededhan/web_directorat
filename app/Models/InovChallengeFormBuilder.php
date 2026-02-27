<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeFormBuilder extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_form_builders';

    protected $fillable = [
        'session_id',
        'phase',
        'form_config',
    ];

    protected $casts = [
        'form_config' => 'array', // JSON casting
    ];

    // Relationships
    public function session()
    {
        return $this->belongsTo(InovChallengeSession::class, 'session_id');
    }

    // Helper methods
    public function getFields()
    {
        return $this->form_config['fields'] ?? [];
    }

    public function getFieldByName($fieldName)
    {
        $fields = $this->getFields();
        foreach ($fields as $field) {
            if (isset($field['name']) && $field['name'] === $fieldName) {
                return $field;
            }
        }
        return null;
    }

    public function validateSubmissionData($data)
    {
        // Custom validation logic based on form_config
        $fields = $this->getFields();
        $errors = [];

        foreach ($fields as $field) {
            if (isset($field['required']) && $field['required']) {
                $fieldName = $field['name'] ?? '';
                if (empty($data[$fieldName])) {
                    $errors[$fieldName] = "Field {$fieldName} is required";
                }
            }
        }

        return $errors;
    }
}
