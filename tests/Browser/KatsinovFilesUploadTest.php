<?php

namespace Tests\Browser;

use App\Models\KatsinovLampiran;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Storage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;


class KatsinovFilesUploadTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            // this automation files neeeds to be created because uploading 40-ish file at the same time is nuts
            $dummyFile = __DIR__.'/files/pdf-dummy.pdf';
            $browser->loginAs(User::find(1))
            ->visitRoute('admin.Katsinov.lampiran.index', ['katsinov_id' => 1])
            ->assertSee('Sistem Upload Lampiran');
            $browser->script("
            let el = document.querySelectorAll('input[type=file]');
            el.forEach((el)=>{
                el.style.border = '3px solid red';
                el.style.boxShadow = '0 0 10px red';
                });");
            $fileInputs = $browser->elements("input[type='file'][name*='aspek_']");
            foreach ($fileInputs as $input) {
                $selector = $input->getAttribute('name');
                $browser->attach("[name='$selector']", $dummyFile);
            }

            $browser->click('#uploadAllBtn');
            // $browser->assertRouteIs('admin.Katsinov.TableKatsinov');
            // $browser->pause(8000);
            $browser->stop();

            // clean the environment after testing
            // if wanted to see the result persist just comments the below code
            // after all the ux is horrendous, imagine u are a user that must upload 47 files
            // KatsinovLampiran::truncate();
            // Storage::disk('public')->deleteDirectory('lampiran_katsinov');
        });
    }
}
