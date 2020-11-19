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
//        TODO This is a bit buggy. The optimization pie can load after triggering pause, so the percentage and text can change
//        $progressPercentage = $I->grabTextFrom(".CircularProgressbar-text");
//        $I->wait(3);
//        $I->see($progressPercentage, ".CircularProgressbar-text");
    }
}
