<?php

namespace App\Exports;

use App\Models\QsSession;
use App\Models\QsSessionRespondent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SessionRespondentExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected QsSession $session;
    protected array $customFieldsSchema;
    protected array $formQuestions;
    protected ?string $consentStatus;
    protected ?array $accessibleUserIds;
    protected int $rowNumber = 0;

    public function __construct(QsSession $session, ?string $consentStatus = null, ?array $accessibleUserIds = null)
    {
        $this->session = $session;
        $this->consentStatus = $consentStatus;
        $this->accessibleUserIds = $accessibleUserIds;
        $this->customFieldsSchema = $session->getCustomFieldsSchema();
        $this->formQuestions = $this->extractFormQuestions();
    }

    public function query()
    {
        $query = QsSessionRespondent::query()
            ->where('qs_session_id', $this->session->id)
            ->with(['bankRespondent.sourceUser', 'addedByUser', 'session.creator'])
            ->latest('id');

        if ($this->accessibleUserIds !== null) {
            $query->whereIn('added_by', $this->accessibleUserIds);
        }

        if (!empty($this->consentStatus)) {
            $query->where('consent_status', $this->consentStatus);
        }

        return $query;
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Title',
            'First Name',
            'Last Name',
            'Full Name',
            'Email',
            'Phone',
            'Category',
            'Institution',
            'Company Name',
            'Department',
            'Job Title',
            'Country',
            'Consent Status',
            'Ditambahkan Oleh',
        ];

        // Append custom field labels
        foreach ($this->customFieldsSchema as $field) {
            $headers[] = $field['label'] ?? ucfirst($field['key'] ?? 'Custom Field');
        }

        // Append questionnaire question labels
        foreach ($this->formQuestions as $q) {
            $headers[] = '[Kuesioner] ' . ($q['label'] ?? $q['id']);
        }

        return $headers;
    }

    /**
     * @param QsSessionRespondent $row
     */
    public function map($row): array
    {
        $this->rowNumber++;
        $bank = $row->bankRespondent;
        $fullname = trim(($bank->first_name ?? '') . ' ' . ($bank->last_name ?? ''));

        $data = [
            $this->rowNumber,
            $bank->title ?? '',
            $bank->first_name ?? '',
            $bank->last_name ?? '',
            $fullname,
            $bank->email ?? '',
            $bank->phone ?? '',
            $row->category === 'academic' ? 'Academic' : 'Employer',
            $bank->institution ?? '',
            $bank->company_name ?? '',
            $bank->department ?? '',
            $bank->job_title ?? '',
            $bank->country ?? 'Indonesia',
            ucfirst($row->consent_status),
            $row->added_by_label,
        ];

        // Append custom field values
        $customValues = is_array($row->custom_fields) ? $row->custom_fields : [];
        foreach ($this->customFieldsSchema as $field) {
            $key = $field['key'] ?? '';
            $data[] = $customValues[$key] ?? '';
        }

        // Append form answers
        $formAnswers = is_array($row->form_answers) ? $row->form_answers : [];
        foreach ($this->formQuestions as $q) {
            $qid = $q['id'];
            $val = $formAnswers[$qid] ?? '';
            if (is_array($val)) {
                $val = implode(', ', $val);
            }
            $data[] = (string) $val;
        }

        return $data;
    }

    /**
     * Extract unique questionnaire questions across academic and employee schemas.
     */
    protected function extractFormQuestions(): array
    {
        $questions = [];
        $seen = [];

        $academicQuestions = $this->session->getFormSchema('academic')['custom_questions'] ?? [];
        foreach ($academicQuestions as $q) {
            if (!empty($q['id']) && !isset($seen[$q['id']])) {
                $seen[$q['id']] = true;
                $questions[] = $q;
            }
        }

        $employeeQuestions = $this->session->getFormSchema('employee')['custom_questions'] ?? [];
        foreach ($employeeQuestions as $q) {
            if (!empty($q['id']) && !isset($seen[$q['id']])) {
                $seen[$q['id']] = true;
                $questions[] = $q;
            }
        }

        return $questions;
    }
}
