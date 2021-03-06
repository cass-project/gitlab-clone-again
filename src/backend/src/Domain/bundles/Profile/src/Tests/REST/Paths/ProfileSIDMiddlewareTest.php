<?php
namespace CASS\Domain\Bundles\Profile\Tests\REST\Paths;
use CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
final class ProfileSIDMiddlewareTest extends ProfileMiddlewareTestCase
{
    public function testGetProfileBySID404()
    {
        $this->requestGetProfileBySID('not-exists')
            ->execute()
            ->expectStatusCode(404)
            ->expectJSONContentType();
    }
    
    public function testGetProfileBySID200()
    {
        $profile = DemoProfileFixture::getProfile();

        $this->requestGetProfileBySID($profile->getSID())
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'entity' => [
                    'profile' => [
                        'collections' => [
                            0 => [
                                'collection_id' => $this->expectId(),
                                'position' => 1,
                            ]
                        ]
                    ],
                    'collections' => [
                        0 => [
                            'id' => $this->expectId(),
                            'sid' => $this->expectString(),
                            'owner_sid' => $this->expectString(),
                            'owner' => [
                                'id' => $this->expectString(),
                                'type' => 'profile'
                            ],
                            'title' => $this->expectString(),
                            'description' => $this->expectString()
                        ]
                    ]
                ]
            ]);
    }
}