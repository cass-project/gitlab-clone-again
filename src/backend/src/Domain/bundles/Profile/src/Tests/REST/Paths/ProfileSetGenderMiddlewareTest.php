<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths;

use CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\GenderFemale;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\GenderMale;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\GenderNotSpecified;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class ProfileSetGenderMiddlewareTest extends ProfileMiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ];
    }

    public function testSetGender()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectAuthError();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType();

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'gender' => [
                            'int' => GenderFemale::INT_CODE,
                            'string' => GenderFemale::STRING_CODE
                        ]
                    ]
                ]
            ]);

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'malE'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true
            ]);

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'gender' => [
                            'int' => GenderMale::INT_CODE,
                            'string' => GenderMale::STRING_CODE,
                        ]
                    ]
                ]
            ]);

    }

    public function testUnsetGender()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'fEmale'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType();

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'gender' => [
                            'int' => GenderFemale::INT_CODE,
                            'string' => GenderFemale::STRING_CODE
                        ]
                    ]
                ]
            ]);

        $this->request('POST', sprintf('/protected/profile/%d/set-gender', $profile->getId()))
            ->auth(DemoAccountFixture::getAccount()->getAPIKey())
            ->setParameters(['gender' => 'not-specified'])
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType();

        $this->requestGet($profile->getId())
            ->execute()
            ->expectJSONContentType()
            ->expectStatusCode(200)
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'id' => $profile->getId(),
                        'gender' => [
                            'int' => GenderNotSpecified::INT_CODE,
                            'string' => GenderNotSpecified::STRING_CODE
                        ]
                    ]
                ]
            ]);
    }

    private function requestGet(int $profileId)
    {
        return $this->request('GET', sprintf('/profile/%d/get', $profileId));
    }
}