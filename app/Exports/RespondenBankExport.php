<?php

namespace App\Exports;

use App\Models\RespondenBank;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class RespondenBankExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    private array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = RespondenBank::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        if (!empty($this->filters['country'])) {
            $query->where('country', 'like', "%{$this->filters['country']}%");
        }

        if (!empty($this->filters['source'])) {
            $query->where('source', $this->filters['source']);
        }

        return $query->orderBy('first_name');
    }

    public function headings(): array
    {
        return [
            'ID', 'Email', 'Title', 'First Name', 'Last Name',
            'Job Title', 'Institution', 'Department', 'Company',
            'Position', 'Country', 'Phone', 'Category', 'Source',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->email,
            $row->title,
            $row->first_name,
            $row->last_name,
            $row->job_title,
            $row->institution,
            $row->department,
            $row->company_name,
            $row->position,
            $row->country,
            $row->phone,
            $row->category,
            $row->source,
            $row->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
