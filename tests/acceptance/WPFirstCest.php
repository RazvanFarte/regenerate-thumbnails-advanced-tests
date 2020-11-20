<?php

class WPFirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }


    public function testPauseButton(AcceptanceTester $I)
    {
        $I->loginAsAdmin();
        $I->amOnAdminPage("tools.php?page=rta_generate_thumbnails");
        $I->seeCheckboxIsChecked('input[value="thumbnail"]');
        $I->seeCheckboxIsChecked('input[value="medium"]');
        $I->seeCheckboxIsChecked('input[value="medium_large"]');
        $I->seeCheckboxIsChecked('input[value="large"]');
        $I->dontSeeCheckboxIsChecked('input[value="post-thumbnail"]');

        $I->click(".rta_regenerate");
        $I->wait(2);
        $I->see("New process started");
        $I->wait(2);
        $I->see("Pause Process");
        $I->click("Pause Process");
        $I->wait(3);
        $I->see("Process is paused");

        $I->reloadPage();
        $I->wait(2);
        $I->see("Process is paused");
        $I->makeScreenshot("pause-button-after-reload-page");
        $I->see("Resume Process");
        $I->see("Stop Process");

        $I->click("Resume Process");
        $I->wait(1);
        $I->see("Interrupted process resumed");
        $I->wait(3);
        $I->see("Pause Process");
        $I->click("Pause Process");

        $I->wait(3);
        $regenerated = $I->grabTextFrom('.progress-count>.current');
        $total = $I->grabTextFrom('.progress-count>.total');

        $I->assertLessThanOrEqual($total, $regenerated, "The amount regenreated thumbnails cannot exceed the total amount of images");
        $I->assertGreaterOrEquals(0, $regenerated, "The amount regenerated thumbnails count cannot be negative");

        $percentage = $I->grabTextFrom(".CircularProgressbar-text");

        $regeneratedCounterInDb = $I->grabNumRecords('wp_shortpixel_queue', ['status >=' => 3]);
        $totalCounterInDb = $I->grabNumRecords('wp_shortpixel_queue');

        $I->assertEquals($regeneratedCounterInDb, $regenerated);
        $I->assertEquals($totalCounterInDb, $total);
    }
}
