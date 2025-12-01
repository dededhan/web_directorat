@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    @php
        // mapping 1
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

        // mapping 2
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
    @endphp

    <div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
        <div class="max-w-[1920px] mx-auto">
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">QS Responden Data</h1>
                    <nav class="flex text-sm text-gray-600 mt-2" aria-label="Breadcrumb">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800 font-medium">QS Responden</span>
                    </nav>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 sm:px-6 py-3">
                <h2 class="text-base sm:text-lg font-semibold text-white">Filter & Search</h2>
            </div>
            
            <form method="GET" action="{{ route('admin_pemeringkatan.qsresponden.index') }}" class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="q" value="{{ request('q') }}" 
                            placeholder="Name, email, institution, company, country..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Categories</option>
                            <option value="academic" {{ request('category') === 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="employee" {{ in_array(request('category'), ['employee', 'employer']) ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input type="text" name="country" value="{{ request('country') }}" 
                            placeholder="e.g. Indonesia" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                        <select name="job_title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All Job Titles</option>
                            <optgroup label="Academic">
                                @foreach ($academicJobTitles as $key => $label)
                                    <option value="{{ $key }}" {{ request('job_title') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Employee">
                                @foreach ($employeeJobTitles as $key => $label)
                                    <option value="{{ $key }}" {{ request('job_title') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Survey 2023</label>
                        <select name="survey_2023" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All</option>
                            <option value="yes" {{ request('survey_2023') === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ request('survey_2023') === 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Survey 2024</label>
                        <select name="survey_2024" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All</option>
                            <option value="yes" {{ request('survey_2024') === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ request('survey_2024') === 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Show Per Page</label>
                        <select name="per_page" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach ([25, 50, 100, 200] as $n)
                                <option value="{{ $n }}" {{ (int) request('per_page', 50) === $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                        <i class='bx bx-filter-alt mr-2'></i>Filter
                    </button>
                    <a href="{{ route('admin_pemeringkatan.qsresponden.index') }}" 
                        class="w-full sm:w-auto px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition flex items-center justify-center">
                        <i class='bx bx-reset mr-2'></i>Reset
                    </a>
                    <div class="hidden sm:block sm:flex-1"></div>
                    <button type="button" class="w-full sm:w-auto px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center justify-center" 
                        @click="$dispatch('open-export-modal')">
                        <i class='bx bx-export mr-2'></i><span class="hidden sm:inline">Export Excel</span><span class="sm:hidden">Export</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Input Source</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">First Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Last Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Institution / Industry</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Company Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Department / Position</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Job Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Country</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">2023</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">2024</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Created At</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($respondens as $i => $responden)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $respondens->firstItem() + $i }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                @php
                                    $displayText = 'Unknown (No responden relation)';

                                    if ($responden->responden) {
                                        if ($responden->responden->user) {
                                            $user = $responden->responden->user;
                                            $role = $user->role;
                                            $name = $user->name;

                                            if ($role === 'admin_direktorat') {
                                                $displayText = 'Direktorat';
                                            } elseif ($role === 'fakultas') {
                                                $displayText = 'Fakultas (' . strtoupper($name) . ')';
                                            } elseif ($role === 'prodi') {
                                                if (Str::contains($name, '-')) {
                                                    $prodiName = trim(Str::after($name, '-'));
                                                    $fakultasName = trim(Str::before($name, '-'));
                                                    $displayText =
                                                        'Prodi (' .
                                                        strtoupper($fakultasName) .
                                                        ' - ' .
                                                        ucwords(strtolower($prodiName)) .
                                                        ')';
                                                } else {
                                                    $displayText = 'Prodi (' . ucwords(strtolower($name)) . ')';
                                                }
                                            } else {
                                                $displayText = ucfirst($role) . ($name ? ' (' . $name . ')' : '');
                                            }
                                        } else {
                                            $displayText = 'Unknown (User Missing)';
                                        }
                                    }
                                    @endphp
                                    {{ $displayText }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ Str::ucfirst($responden->title) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ Str::title($responden->first_name) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ Str::title($responden->last_name) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->institution ? Str::title($responden->institution) : '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->company_name ? Str::title($responden->company_name) : '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if(in_array(strtolower($responden->category), ['employee', 'employer']))
                                        {{ $responden->position ?? '-' }}
                                    @else
                                        {{ $responden->department ?? '-' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                @php
                                    $jobTitleKey = $responden->job_title;
                                    $jobTitleDisplay = Str::title(str_replace('_', ' ', $jobTitleKey));

                                    if ($responden->category === 'academic') {
                                        $jobTitleDisplay = $academicJobTitles[$jobTitleKey] ?? $jobTitleDisplay;
                                    } elseif (
                                        $responden->category === 'employee' ||
                                        $responden->category === 'employer'
                                    ) {
                                        $jobTitleDisplay = $employeeJobTitles[$jobTitleKey] ?? $jobTitleDisplay;
                                    }
                                    @endphp
                                    {{ $jobTitleDisplay }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ Str::title($responden->country) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $responden->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $responden->phone }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $responden->survey_2023 === 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ Str::ucfirst($responden->survey_2023) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $responden->survey_2024 === 'yes' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ Str::ucfirst($responden->survey_2024) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    @if(in_array(strtolower($responden->category), ['employee', 'employer']))
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Employee
                                        </span>
                                    @elseif(strtolower($responden->category) === 'academic')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Academic
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ Str::ucfirst($responden->category) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $responden->created_at?->format('d M Y') ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin_pemeringkatan.qsresponden.edit', $responden->id) }}" 
                                            class="px-3 py-1 bg-amber-500 text-white rounded hover:bg-amber-600 transition">
                                            <i class='bx bxs-edit'></i>
                                        </a>
                                        <button type="button" class="delete-btn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" 
                                            data-id="{{ $responden->id }}">
                                            <i class='bx bxs-trash'></i>
                                        </button>
                                        <form id="delete-form-{{ $responden->id }}"
                                            action="{{ route('admin_pemeringkatan.qsresponden.destroy', $responden->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="px-4 py-8 text-center text-gray-500">
                                    <i class='bx bx-folder-open text-4xl mb-2'></i>
                                    <p>No QS Responden data available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($respondens->total() > 0)
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Showing {{ $respondens->firstItem() }} to {{ $respondens->lastItem() }} of {{ $respondens->total() }} results
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ $respondens->appends(request()->query())->previousPageUrl() }}" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition {{ $respondens->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <i class='bx bx-chevron-left'></i> Previous
                        </a>
                        <a href="{{ $respondens->appends(request()->query())->nextPageUrl() }}" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition {{ !$respondens->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            Next <i class='bx bx-chevron-right'></i>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('admin_pemeringkatan.qsresponden.modals')

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const respondenId = this.dataset.id;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This QS Responden data will be permanently deleted!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${respondenId}`).submit();
                    }
                });
            });
        });
    </script>
        </div>
    </div>
@endsection
