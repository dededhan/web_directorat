<?php

namespace App\Exports;

use App\Models\RespondenAnswer;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RespondenAnswerExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    /** @var array<string, mixed> */
    protected array $filters;

    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = RespondenAnswer::query()->latest();

        $q = trim((string)($this->filters['q'] ?? ''));
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('institution', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%")
                    ->orWhere('country', 'like', "%{$q}%")
                    ->orWhere('job_title', 'like', "%{$q}%");
            });
        }

        $category = $this->filters['category'] ?? null;
        if (!empty($category)) {
            if ($category === 'employee' || $category === 'employer') {
                $query->whereIn('category', ['employee', 'employer']);
            } else {
                $query->where('category', $category);
            }
        }

        $country = trim((string)($this->filters['country'] ?? ''));
        if ($country !== '') {
            $query->where('country', 'like', "%{$country}%");
        }

        if (!empty($this->filters['survey_2023'])) {
            $query->where('survey_2023', $this->filters['survey_2023']);
        }

        if (!empty($this->filters['survey_2024'])) {
            $query->where('survey_2024', $this->filters['survey_2024']);
        }

        if (!empty($this->filters['job_title'])) {
            $query->where('job_title', $this->filters['job_title']);
        }

        // Date range
        $start = $this->filters['start_date'] ?? null;
        $end = $this->filters['end_date'] ?? null;
        if (!empty($start) && !empty($end)) {
            try {
                $query->whereBetween('created_at', [\Carbon\Carbon::parse($start)->startOfDay(), \Carbon\Carbon::parse($end)->endOfDay()]);
            } catch (\Exception $e) {
                // Ignore invalid date inputs
            }
        } elseif (!empty($start)) {
            try {
                $query->where('created_at', '>=', \Carbon\Carbon::parse($start)->startOfDay());
            } catch (\Exception $e) {}
        } elseif (!empty($end)) {
            try {
                $query->where('created_at', '<=', \Carbon\Carbon::parse($end)->endOfDay());
            } catch (\Exception $e) {}
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Title',
            'First Name',
            'Last Name',
            'Institution / Industry',
            'Company Name',
            'Job Title',
            'Country',
            'Email',
            'Phone',
            '2023 Survey',
            '2024 Survey',
            'Category',
            'Created At',
        ];
    }

    public function map($row): array
    {
        $employeeJobTitles = [
            'ceo' => 'CEO/President/Managing Director',
            'coo' => 'COO/CFO/CTO/CIO/CMO',
            'vp' => 'Director/Partner/Vice President',
            'shr' => 'Senior Human Resources/Recruitment',
            'ohr' => 'Other Human Resources/Recruitment',
            'exe' => 'Manager/Executive',
            'cons' => 'Consultant/Advisor',
            'coor' => 'Coordinator/Officer',
            'ana' => 'Analyst/Specialist',
            'ass' => 'Assistant/Administrator',
            'other' => 'Other',
        ];

        $academicJobTitles = [
            'vc' => 'President/Vice-Chancellor',
            'vp' => 'Vice-President/Deputy Vice-Chancellor',
            'sa' => 'Senior Administrator',
            'hod' => 'Head of Department',
            'ass' => 'Professor/Associate Professor',
            'ap' => 'Assistant Professor',
            'sl' => 'Senior Lecturer',
            'lec' => 'Lecturer',
            'rs' => 'Research Specialist',
            'fm' => 'Administrator/Functional Manager',
            'ra' => 'Research Assistant',
            'ta' => 'Teaching Assistant',
            'ao' => 'Admissions Officer',
            'la' => 'Librarian/Library Assistant',
            'other' => 'Other',
        ];

        $jobKey = $row->job_title;
        $jobLabel = $jobKey;
        if ($row->category === 'academic') {
            $jobLabel = $academicJobTitles[$jobKey] ?? $jobKey;
        } else {
            $jobLabel = $employeeJobTitles[$jobKey] ?? $jobKey;
        }

        $categoryLabel = $row->category === 'employer' ? 'Employee' : ucfirst((string)$row->category);

        return [
            ucfirst((string)$row->title),
            ucfirst((string)$row->first_name),
            ucfirst((string)$row->last_name),
            ucfirst((string)$row->institution),
            (string)$row->company_name,
            $jobLabel,
            ucfirst((string)$row->country),
            (string)$row->email,
            (string)$row->phone,
            ucfirst((string)$row->survey_2023),
            ucfirst((string)$row->survey_2024),
            $categoryLabel,
            optional($row->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}


