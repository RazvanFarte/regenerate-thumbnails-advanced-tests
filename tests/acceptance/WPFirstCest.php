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
        $I->see("New process started");
        $I->click("Pause Process");
        $I->see("Process is paused");

        $I->reloadPage();
        $I->see("Interrupted process resumed");
        $I->see("Process is paused");
        $I->makeScreenshot("pause-button-after-reload-page");
        $I->see("Resume Process");
        $I->see("Stop Process");

        $I->click("Resume Process");
        $I->see("Interrupted process resumed");
        $I->see("Pause Process");
        $I->click("Pause Process");
        $progressPercentage = $I->grabTextFrom(".CircularProgressbar-text");
        $I->wait(5);
        $I->see($progressPercentage, ".CircularProgressbar-text");
    }
}
