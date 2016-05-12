<?php
namespace Domain\Auth\Tests;

use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Tests\Fixtures\DemoProfileFixture;

/**
 * @backupGlobals disabled
 */
class AuthMiddlewareTest extends MiddlewareTestCase
{
    protected function getFixtures(): array
    {
        return [];
    }

    public function testSignUp()
    {
        $json = [
            'email' => 'demo@gmail.com',
            'password' => '1234',
            'repeat' => '1234'
        ];

        $this->requestSignUp($json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'api_key' => $this->expectString(),
                'account' => [
                    'id' => $this->expectId(),
                    'email' => $json['email'],
                    'disabled' => [
                        'is_disabled' => false
                    ]
                ],
                'profiles' => [
                    [
                        'id' => $this->expectId(),
                        'account_id' => $this->expectId(),
                        'is_initialized' => false,
                        'is_current' => true,
                        'greetings' => [
                            'id' => $this->expectId(),
                            'profile_id' => $this->expectId(),
                            'greetings_method' => ProfileGreetings::DEFAULT_GREETINGS,
                        ]
                    ]
                ]
            ])
        ;
    }

    public function testSignIn()
    {
        $this->upFixtures([
            new DemoAccountFixture(),
            new DemoProfileFixture()
        ]);

        $account = DemoAccountFixture::getAccount();
        $profile = DemoProfileFixture::getProfile();

        $json = [
            'email' => $account->getEmail(),
            'password' => DemoAccountFixture::ACCOUNT_PASSWORD
        ];

        $this->requestSignIn($json)
            ->execute()
            ->expectStatusCode(200)
            ->expectJSONContentType()
            ->expectJSONBody([
                'success' => true,
                'api_key' => $account->getAPIKey(),
                'account' => [
                    'id' => $account->getId(),
                    'email' => $account->getEmail(),
                    'disabled' => [
                        'is_disabled' => false
                    ]
                ],
                'profiles' => [
                    [
                        'id' => $profile->getId(),
                        'account_id' => $account->getId(),
                        'is_initialized' => false,
                        'is_current' => true,
                        'greetings' => [
                            'id' => $profile->getProfileGreetings()->getId(),
                            'profile_id' => $profile->getId(),
                            'greetings_method' => ProfileGreetings::DEFAULT_GREETINGS,
                        ]
                    ]
                ]
            ])
        ;
    }

    private function requestSignUp(array $json): RESTRequest
    {
        return $this->request('PUT', '/auth/sign-up')
            ->setParameters($json);
    }

    private function requestSignIn(array $json): RESTRequest
    {
        return $this->request('POST', '/auth/sign-in')
            ->setParameters($json);
    }
}