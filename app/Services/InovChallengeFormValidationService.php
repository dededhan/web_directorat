<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InovChallengeFormValidationService
{
    /**
     * Generate validation rules from form configuration.
     *
     * @param array $formConfig
     * @return array
     */
    public function generateValidationRules(array $formConfig): array
    {
        $rules = [];
        $messages = [];
        $attributes = [];

        foreach ($formConfig as $field) {
            $fieldName = $field['name'] ?? null;
            $fieldType = $field['type'] ?? 'text';
            $isRequired = $field['required'] ?? false;

            if (!$fieldName) {
                continue;
            }

            $fieldRules = [];

            // Required validation
            if ($isRequired) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            // Type-specific validation
            switch ($fieldType) {
                case 'email':
                    $fieldRules[] = 'email';
                    $fieldRules[] = 'max:255';
                    break;

                case 'number':
                    $fieldRules[] = 'numeric';
                    break;

                case 'date':
                    $fieldRules[] = 'date';
                    break;

                case 'text':
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:255';
                    break;

                case 'textarea':
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:65535';
                    break;

                case 'select':
                case 'radio':
                    if (isset($field['options']) && is_array($field['options'])) {
                        $validOptions = array_keys($field['options']);
                        $fieldRules[] = 'in:' . implode(',', $validOptions);
                    }
                    break;

                case 'checkbox':
                    $fieldRules[] = 'array';
                    if (isset($field['options']) && is_array($field['options'])) {
                        $validOptions = array_keys($field['options']);
                        $rules[$fieldName . '.*'] = 'in:' . implode(',', $validOptions);
                    }
                    break;

                case 'file':
                    $fileRules = [];

                    if ($isRequired) {
                        $fileRules[] = 'required';
                    } else {
                        $fileRules[] = 'nullable';
                    }

                    $fileRules[] = 'file';

                    // Max file size (in KB from config, convert to KB for Laravel)
                    if (isset($field['max_size'])) {
                        $fileRules[] = 'max:' . $field['max_size'];
                    }

                    // File extensions
                    if (isset($field['accept']) && !empty($field['accept'])) {
                        $extensions = $this->parseFileExtensions($field['accept']);
                        if (!empty($extensions)) {
                            $fileRules[] = 'mimes:' . implode(',', $extensions);
                        }
                    }

                    $fieldRules = $fileRules;

                    // Handle multiple files
                    if (isset($field['multiple']) && $field['multiple']) {
                        $rules[$fieldName] = 'array';
                        $rules[$fieldName . '.*'] = implode('|', $fileRules);
                        continue 2; // Skip the main rule assignment below
                    }
                    break;
            }

            // Assign rules to field
            if (!empty($fieldRules)) {
                $rules[$fieldName] = implode('|', $fieldRules);
            }

            // Custom attribute name for better error messages
            $attributes[$fieldName] = $field['label'] ?? $fieldName;

            // Custom messages (optional)
            if ($isRequired) {
                $messages[$fieldName . '.required'] = $field['label'] . ' wajib diisi.';
            }
        }

        return [
            'rules' => $rules,
            'messages' => $messages,
            'attributes' => $attributes,
        ];
    }

    /**
     * Validate data against form configuration.
     *
     * @param array $data
     * @param array $formConfig
     * @return array
     * @throws ValidationException
     */
    public function validateSubmissionData(array $data, array $formConfig): array
    {
        $validation = $this->generateValidationRules($formConfig);

        $validator = Validator::make($data, $validation['rules'], $validation['messages']);
        $validator->setAttributeNames($validation['attributes']);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    /**
     * Parse file extensions from accept attribute.
     *
     * @param string $accept
     * @return array
     */
    protected function parseFileExtensions(string $accept): array
    {
        // Parse accept attribute like ".pdf,.doc,.docx" or "image/*"
        $extensions = [];
        $parts = array_map('trim', explode(',', $accept));

        foreach ($parts as $part) {
            // Remove leading dot if present
            $ext = ltrim($part, '.');

            // Handle MIME type patterns
            if (strpos($ext, '/') !== false) {
                // For simplicity, we'll skip MIME types and rely on explicit extensions
                continue;
            }

            $extensions[] = $ext;
        }

        return $extensions;
    }

    /**
     * Get validation rules as array (useful for manual validation).
     *
     * @param array $formConfig
     * @return array
     */
    public function getRules(array $formConfig): array
    {
        return $this->generateValidationRules($formConfig)['rules'];
    }

    /**
     * Get validation messages as array.
     *
     * @param array $formConfig
     * @return array
     */
    public function getMessages(array $formConfig): array
    {
        return $this->generateValidationRules($formConfig)['messages'];
    }

    /**
     * Get attribute names for better error messages.
     *
     * @param array $formConfig
     * @return array
     */
    public function getAttributes(array $formConfig): array
    {
        return $this->generateValidationRules($formConfig)['attributes'];
    }

    /**
     * Validate specific fields only.
     *
     * @param array $data
     * @param array $formConfig
     * @param array $fieldsToValidate
     * @return array
     * @throws ValidationException
     */
    public function validateSpecificFields(array $data, array $formConfig, array $fieldsToValidate): array
    {
        // Filter form config to only include specified fields
        $filteredConfig = array_filter($formConfig, function ($field) use ($fieldsToValidate) {
            return in_array($field['name'] ?? null, $fieldsToValidate);
        });

        return $this->validateSubmissionData($data, $filteredConfig);
    }

    /**
     * Check if a field is required in the form config.
     *
     * @param array $formConfig
     * @param string $fieldName
     * @return bool
     */
    public function isFieldRequired(array $formConfig, string $fieldName): bool
    {
        foreach ($formConfig as $field) {
            if (($field['name'] ?? null) === $fieldName) {
                return $field['required'] ?? false;
            }
        }

        return false;
    }

    /**
     * Get field configuration by name.
     *
     * @param array $formConfig
     * @param string $fieldName
     * @return array|null
     */
    public function getFieldConfig(array $formConfig, string $fieldName): ?array
    {
        foreach ($formConfig as $field) {
            if (($field['name'] ?? null) === $fieldName) {
                return $field;
            }
        }

        return null;
    }

    /**
     * Get all required field names from form config.
     *
     * @param array $formConfig
     * @return array
     */
    public function getRequiredFields(array $formConfig): array
    {
        $requiredFields = [];

        foreach ($formConfig as $field) {
            if (($field['required'] ?? false) && isset($field['name'])) {
                $requiredFields[] = $field['name'];
            }
        }

        return $requiredFields;
    }
}
