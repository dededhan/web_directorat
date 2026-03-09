<?php

namespace App\Http\Controllers\InovChalenge\AdminPanel;

use App\Http\Controllers\InovChalenge\TahapController as BaseController;
use App\Models\InovChalengeTahap;

/**
 * Tahap controller for Admin InovChallenge panel.
 * Extends the original TahapController but returns admin_inovchalenge views.
 */
class TahapController extends BaseController
{
    public function edit(InovChalengeTahap $tahap)
    {
        $tahap->load(['session', 'sections.fields', 'unsectionedFields']);

        return view('admin_inovchalenge.inovchalenge.tahap.edit', compact('tahap'));
    }
}
