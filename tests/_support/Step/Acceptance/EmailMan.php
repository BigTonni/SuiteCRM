<?php

namespace Step\Acceptance;

class EmailMan extends \AcceptanceTester
{
    
    private static $testerEmailAddress = 'sa.tester2@gmail.com';
    private static $testerEmailPassword = 'chilisauce';
    
    /**
     * Go to email settings
     */
    public function gotoEmailSettings()
    {
        $I = new NavigationBar($this->getScenario());
        $I->clickUserMenuItem('#admin_link');
        $I->click('#mass_Email_config');
    }

    /**
     * Populate email settings
     *
     * @param $name
     */
    public function createEmailSettings()
    {
        $I = new NavigationBar($this->getScenario());
        $EditView = new EditView($this->getScenario());
        $faker = $this->getFaker();

        $I->clickUserMenuItem('#admin_link');
        $I->click('#mass_Email_config');

        $I->fillField('#notify_fromname', $faker->name());
        $I->fillField('#notify_fromaddress', $faker->email);
        $I->click('#gmail-button');

        $I->checkOption('#mail_smtpauth_req');
        $I->fillField('#mail_smtpuser', self::$testerEmailAddress);
        $I->executeJS('SUGAR.util.setEmailPasswordEdit(\'mail_smtppass\')');
        $I->fillField('#mail_smtppass', self::$testerEmailPassword);
        $I->checkOption('#notify_allow_default_outbound');
        
        $I->waitForJS("$('#sendTestOutboundEmailSettingsBtn').click();");
        $I->fillField('outboundtest_from_address', 'sa.tester2@gmail.com');
        $I->waitForJS('$(\'#testOutbound input[type="button"]\')[0].click();');
        $I->wait(10);
        $I->see('An email was sent to the specified email address using the provided outgoing mail settings. ' .
                'Please check to see if the email was received to verify the settings are correct.');
        $I->waitForJS("$('#yui-gen1-button').click();");

        $EditView->clickSaveButton();
    }
}
