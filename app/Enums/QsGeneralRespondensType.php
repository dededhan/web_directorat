<?php

namespace App\Enums;

enum QsGeneralRespondensType : string
{
    case Student = 'student';
    case Lecturer = 'dosen';
    case Teacher = 'guru';
    case Profetional = 'profesional';
    case Enterpreneur = 'wiraswasta';
}
