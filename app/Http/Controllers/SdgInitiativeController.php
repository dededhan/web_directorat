<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheImpactSdg;
use App\Models\TheImpactContent;

class SdgInitiativeController extends Controller
{
    public function index()
    {
        $sdgs = TheImpactSdg::where('is_active', true)
            ->orderBy('number')
            ->get();

        // Get top 3 featured SDGs with content
        $featuredSdgs = TheImpactSdg::whereIn('number', [1, 2, 6])
            ->with(['rootContents' => function($query) {
                $query->where('is_active', true)->limit(1);
            }])
            ->get();

        return view('Pemeringkatan.the_ir_initiatives', compact('sdgs', 'featuredSdgs'));
    }

    public function show(Request $request, $id)
    {
        $selectedYear = $request->get('year');
        
        $sdg = TheImpactSdg::where('number', $id)
            ->where('is_active', true)
            ->with(['rootContents' => function($query) use ($selectedYear) {
                $query->where('is_active', true);
                if ($selectedYear) {
                    $query->where('year', $selectedYear);
                }
                $query->orderBy('order');
            }, 'rootContents.children' => function($query) use ($selectedYear) {
                $query->where('is_active', true);
                if ($selectedYear) {
                    $query->where('year', $selectedYear);
                }
                $query->orderBy('order');
            }])
            ->firstOrFail();

        // Get available years from database
        $years = TheImpactContent::where('sdg_id', $sdg->id)
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('Pemeringkatan.sdg_detail', compact('sdg', 'years', 'selectedYear'));
    }

    private static function getSdgData()
    {
        return [
            1 => [
                'number' => 1,
                'title' => 'No Poverty',
                'subtitle' => 'End poverty in all its forms everywhere',
                'color' => '#e5243b',
                'featured_initiative' => [
                    'title' => 'Ensuring Education Access for Low-Income Students',
                    'description' => 'At Universitas Indonesia, we are committed to breaking the cycle of poverty by providing accessible education to students from disadvantaged backgrounds. Through targeted scholarships, inclusive admissions policies, and supportive academic programs, we enable these students to pursue higher education and secure better futures.'
                ],
                'goals' => [
                    [
                        'category' => 'University anti-poverty programmes',
                        'description' => 'University anti-poverty initiatives contribute to SDG 1 by developing educational frameworks and community partnerships that address root causes of poverty. Through targeted scholarships, financial literacy education, and inclusive support systems, universities empower individuals with knowledge and skills necessary for long-term economic stability and prosperity.',
                        'items' => [
                            'Bottom Financial Quintile Admission Target',
                            'Bottom Financial Quintile Student Success',
                            'Low Income Student Support',
                            'Bottom financial quintile student support',
                            'Low or Lower-middle Income Countries Student Support'
                        ]
                    ]
                ]
            ],
            2 => [
                'number' => 2,
                'title' => 'Zero Hunger',
                'subtitle' => 'End hunger, achieve food security and improved nutrition and promote sustainable agriculture',
                'color' => '#DDA63A',
                'featured_initiative' => [
                    'title' => 'Providing Meals to Food-Insecure Communities Across the Country',
                    'description' => 'At Universitas Negeri Jakarta, we actively combat national hunger by partnering with local farmers for sustainable agriculture and ensuring food security for vulnerable communities. Through our initiatives, we provide thousands of meals annually to those in need across the country.'
                ],
                'goals' => [
                    [
                        'category' => 'Campus food waste and hunger',
                        'description' => 'Universities combat hunger by implementing food waste reduction programs and redistributing surplus meals to food-insecure students and local communities.',
                        'items' => [
                            'Campus Food Waste Tracking',
                            'Student Hunger Free Programs',
                            'Sustainable Campus Food Options',
                            'Campus food bank programs'
                        ]
                    ]
                ]
            ],
            3 => [
                'number' => 3,
                'title' => 'Good Health and Well-Being',
                'subtitle' => 'Ensure healthy lives and promote well-being for all at all ages',
                'color' => '#4C9F38',
                'featured_initiative' => [
                    'title' => 'Comprehensive Healthcare Services for University Community',
                    'description' => 'UNJ provides comprehensive healthcare services including mental health support, preventive care programs, and health education initiatives. Our student health center offers free medical consultations, counseling services, and wellness programs to promote healthy lifestyles among students and staff.'
                ],
                'goals' => [
                    [
                        'category' => 'Health and wellbeing programmes',
                        'description' => 'Universities promote health through accessible healthcare services, mental health support, and wellness programs for students and staff.',
                        'items' => [
                            'Student Health Services',
                            'Mental Health Support Programs',
                            'Health Education Initiatives',
                            'Sports and Recreation Facilities'
                        ]
                    ]
                ]
            ],
            4 => [
                'number' => 4,
                'title' => 'Quality Education',
                'subtitle' => 'Ensure inclusive and equitable quality education and promote lifelong learning opportunities for all',
                'color' => '#C5192D',
                'featured_initiative' => [
                    'title' => 'Inclusive Education and Lifelong Learning Programs',
                    'description' => 'UNJ is committed to providing quality education for all. We offer inclusive programs for students with disabilities, continuing education for professionals, and community outreach programs that extend educational opportunities beyond traditional boundaries.'
                ],
                'goals' => [
                    [
                        'category' => 'Access to quality education',
                        'description' => 'Universities ensure equitable access to quality education through scholarships, inclusive policies, and support systems for diverse student populations.',
                        'items' => [
                            'Scholarship Programs',
                            'Inclusive Admissions Policies',
                            'Academic Support Services',
                            'Community Education Programs'
                        ]
                    ]
                ]
            ],
            5 => [
                'number' => 5,
                'title' => 'Gender Equality',
                'subtitle' => 'Achieve gender equality and empower all women and girls',
                'color' => '#FF3A21',
                'featured_initiative' => [
                    'title' => 'Women Empowerment and Gender Equality Initiatives',
                    'description' => 'UNJ promotes gender equality through fair representation in leadership positions, support programs for women in STEM fields, anti-discrimination policies, and awareness campaigns on gender-based violence prevention.'
                ],
                'goals' => [
                    [
                        'category' => 'Gender equality programmes',
                        'description' => 'Universities advance gender equality through equal opportunity policies, women\'s leadership programs, and creating safe inclusive environments.',
                        'items' => [
                            'Women in Leadership Programs',
                            'Gender-Based Violence Prevention',
                            'Equal Pay Policies',
                            'Women in STEM Initiatives'
                        ]
                    ]
                ]
            ],
            6 => [
                'number' => 6,
                'title' => 'Clean Water and Sanitation',
                'subtitle' => 'Ensure availability and sustainable management of water and sanitation for all',
                'color' => '#26BDE2',
                'featured_initiative' => [
                    'title' => 'Providing Access to Clean Water and Sanitation for All',
                    'description' => 'At Universitas Negeri Jakarta, we are dedicated to improving water and sanitation access by implementing sustainable water management practices and educating communities about the importance of hygiene. Through these efforts, we help ensure that clean water and adequate sanitation are available to everyone on campus and in the surrounding areas.'
                ],
                'goals' => [
                    [
                        'category' => 'Water stewardship programmes',
                        'description' => 'Universities implement water conservation, treatment systems, and education programs to ensure sustainable water use and access to clean water.',
                        'items' => [
                            'Water Conservation Programs',
                            'Rainwater Harvesting Systems',
                            'Wastewater Treatment Facilities',
                            'Water Quality Monitoring'
                        ]
                    ]
                ]
            ],
            7 => [
                'number' => 7,
                'title' => 'Affordable and Clean Energy',
                'subtitle' => 'Ensure access to affordable, reliable, sustainable and modern energy for all',
                'color' => '#FCC30B',
                'featured_initiative' => [
                    'title' => 'Renewable Energy and Energy Efficiency Initiatives',
                    'description' => 'UNJ is transitioning to clean energy sources by installing solar panels, implementing energy-efficient systems, and conducting research on renewable energy technologies to reduce our carbon footprint and promote sustainable energy practices.'
                ],
                'goals' => [
                    [
                        'category' => 'Clean energy initiatives',
                        'description' => 'Universities promote clean energy through renewable energy installations, energy efficiency programs, and research on sustainable energy solutions.',
                        'items' => [
                            'Solar Panel Installations',
                            'Energy Efficiency Programs',
                            'Renewable Energy Research',
                            'Smart Building Management Systems'
                        ]
                    ]
                ]
            ],
            8 => [
                'number' => 8,
                'title' => 'Decent Work and Economic Growth',
                'subtitle' => 'Promote sustained, inclusive and sustainable economic growth, full and productive employment and decent work for all',
                'color' => '#A21942',
                'featured_initiative' => [
                    'title' => 'Career Development and Employment Support Programs',
                    'description' => 'UNJ prepares students for the workforce through career counseling, internship programs, entrepreneurship training, and partnerships with industries to create employment opportunities and promote decent work practices.'
                ],
                'goals' => [
                    [
                        'category' => 'Employment and economic growth',
                        'description' => 'Universities support economic growth through career services, entrepreneurship programs, and partnerships with industries.',
                        'items' => [
                            'Career Counseling Services',
                            'Internship Programs',
                            'Entrepreneurship Training',
                            'Industry Partnership Programs'
                        ]
                    ]
                ]
            ],
            9 => [
                'number' => 9,
                'title' => 'Industry, Innovation and Infrastructure',
                'subtitle' => 'Build resilient infrastructure, promote inclusive and sustainable industrialization and foster innovation',
                'color' => '#FD6925',
                'featured_initiative' => [
                    'title' => 'Innovation Hub and Infrastructure Development',
                    'description' => 'UNJ establishes innovation centers, research facilities, and technology parks to foster innovation, support start-ups, and develop sustainable infrastructure solutions for Indonesia\'s industrial growth.'
                ],
                'goals' => [
                    [
                        'category' => 'Innovation and infrastructure programmes',
                        'description' => 'Universities drive innovation through research centers, technology transfer offices, and infrastructure development projects.',
                        'items' => [
                            'Innovation Centers',
                            'Research Facilities',
                            'Technology Transfer Programs',
                            'Sustainable Infrastructure Projects'
                        ]
                    ]
                ]
            ],
            10 => [
                'number' => 10,
                'title' => 'Reduced Inequalities',
                'subtitle' => 'Reduce inequality within and among countries',
                'color' => '#DD1367',
                'featured_initiative' => [
                    'title' => 'Promoting Equality and Social Inclusion',
                    'description' => 'UNJ works to reduce inequalities by ensuring equal opportunities for all students regardless of background, providing support for marginalized groups, and promoting inclusive policies and practices across campus.'
                ],
                'goals' => [
                    [
                        'category' => 'Equality and inclusion programmes',
                        'description' => 'Universities reduce inequalities through inclusive admissions, support for marginalized groups, and anti-discrimination policies.',
                        'items' => [
                            'Inclusive Admissions Policies',
                            'Support for Marginalized Students',
                            'Anti-Discrimination Policies',
                            'Diversity and Inclusion Training'
                        ]
                    ]
                ]
            ],
            11 => [
                'number' => 11,
                'title' => 'Sustainable Cities and Communities',
                'subtitle' => 'Make cities and human settlements inclusive, safe, resilient and sustainable',
                'color' => '#FD9D24',
                'featured_initiative' => [
                    'title' => 'Building Sustainable Campus Communities',
                    'description' => 'UNJ creates a sustainable campus environment through green building practices, public transportation access, waste management systems, and community engagement programs that promote sustainable urban living.'
                ],
                'goals' => [
                    [
                        'category' => 'Sustainable campus initiatives',
                        'description' => 'Universities build sustainable communities through green infrastructure, waste reduction, and community engagement programs.',
                        'items' => [
                            'Green Building Practices',
                            'Public Transportation Access',
                            'Waste Management Systems',
                            'Community Engagement Programs'
                        ]
                    ]
                ]
            ],
            12 => [
                'number' => 12,
                'title' => 'Responsible Consumption and Production',
                'subtitle' => 'Ensure sustainable consumption and production patterns',
                'color' => '#BF8B2E',
                'featured_initiative' => [
                    'title' => 'Promoting Sustainable Consumption and Production',
                    'description' => 'UNJ promotes responsible consumption through waste reduction programs, sustainable procurement policies, circular economy initiatives, and education on sustainable consumption practices.'
                ],
                'goals' => [
                    [
                        'category' => 'Sustainable consumption programmes',
                        'description' => 'Universities promote responsible consumption through waste reduction, sustainable procurement, and circular economy practices.',
                        'items' => [
                            'Waste Reduction Programs',
                            'Sustainable Procurement Policies',
                            'Circular Economy Initiatives',
                            'Sustainable Consumption Education'
                        ]
                    ]
                ]
            ],
            13 => [
                'number' => 13,
                'title' => 'Climate Action',
                'subtitle' => 'Take urgent action to combat climate change and its impacts',
                'color' => '#3F7E44',
                'featured_initiative' => [
                    'title' => 'Climate Change Mitigation and Adaptation',
                    'description' => 'UNJ takes climate action through carbon footprint reduction, climate research programs, climate education initiatives, and partnerships for climate solutions.'
                ],
                'goals' => [
                    [
                        'category' => 'Climate action programmes',
                        'description' => 'Universities combat climate change through emissions reduction, climate research, and education on climate action.',
                        'items' => [
                            'Carbon Footprint Reduction',
                            'Climate Research Programs',
                            'Climate Education Initiatives',
                            'Climate Solution Partnerships'
                        ]
                    ]
                ]
            ],
            14 => [
                'number' => 14,
                'title' => 'Life Below Water',
                'subtitle' => 'Conserve and sustainably use the oceans, seas and marine resources for sustainable development',
                'color' => '#0A97D9',
                'featured_initiative' => [
                    'title' => 'Marine Conservation and Ocean Research',
                    'description' => 'UNJ contributes to ocean conservation through marine research, education on ocean sustainability, partnerships with marine conservation organizations, and advocacy for marine protection policies.'
                ],
                'goals' => [
                    [
                        'category' => 'Marine conservation programmes',
                        'description' => 'Universities protect marine life through research, conservation projects, and education on ocean sustainability.',
                        'items' => [
                            'Marine Research Programs',
                            'Ocean Conservation Projects',
                            'Marine Education Initiatives',
                            'Marine Protection Advocacy'
                        ]
                    ]
                ]
            ],
            15 => [
                'number' => 15,
                'title' => 'Life on Land',
                'subtitle' => 'Protect, restore and promote sustainable use of terrestrial ecosystems',
                'color' => '#56C02B',
                'featured_initiative' => [
                    'title' => 'Biodiversity Conservation and Ecosystem Restoration',
                    'description' => 'UNJ protects life on land through biodiversity research, reforestation programs, ecosystem restoration projects, and education on sustainable land use practices.'
                ],
                'goals' => [
                    [
                        'category' => 'Biodiversity programmes',
                        'description' => 'Universities protect biodiversity through research, conservation projects, and sustainable land management practices.',
                        'items' => [
                            'Biodiversity Research',
                            'Reforestation Programs',
                            'Ecosystem Restoration Projects',
                            'Sustainable Land Use Education'
                        ]
                    ]
                ]
            ],
            16 => [
                'number' => 16,
                'title' => 'Peace, Justice and Strong Institutions',
                'subtitle' => 'Promote peaceful and inclusive societies for sustainable development',
                'color' => '#00689D',
                'featured_initiative' => [
                    'title' => 'Promoting Peace, Justice and Strong Governance',
                    'description' => 'UNJ promotes peace and justice through legal aid services, governance research, civic education programs, and partnerships with justice institutions to build strong, accountable institutions.'
                ],
                'goals' => [
                    [
                        'category' => 'Peace and justice programmes',
                        'description' => 'Universities promote peace through legal services, governance research, and civic engagement programs.',
                        'items' => [
                            'Legal Aid Services',
                            'Governance Research',
                            'Civic Education Programs',
                            'Justice Institution Partnerships'
                        ]
                    ]
                ]
            ],
            17 => [
                'number' => 17,
                'title' => 'Partnerships for the Goals',
                'subtitle' => 'Strengthen the means of implementation and revitalize the global partnership for sustainable development',
                'color' => '#19486A',
                'featured_initiative' => [
                    'title' => 'Building Global Partnerships for Sustainable Development',
                    'description' => 'UNJ fosters partnerships through international collaborations, multi-stakeholder initiatives, knowledge sharing platforms, and resource mobilization for achieving all SDGs together.'
                ],
                'goals' => [
                    [
                        'category' => 'Partnership programmes',
                        'description' => 'Universities build partnerships through collaborations with governments, businesses, NGOs, and other institutions.',
                        'items' => [
                            'International Collaborations',
                            'Multi-Stakeholder Initiatives',
                            'Knowledge Sharing Platforms',
                            'Resource Mobilization Programs'
                        ]
                    ]
                ]
            ]
        ];
    }
}
