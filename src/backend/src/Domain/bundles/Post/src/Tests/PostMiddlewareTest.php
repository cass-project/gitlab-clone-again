<?php


namespace Domain\Post\Tests;


use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Domain\Account\Tests\Fixtures\DemoAccountFixture;
use Domain\Post\Tests\Fixtures\DemoCollectionFixture;
use Domain\Post\Tests\Fixtures\DemoCommunityFixture;
use Domain\Post\Tests\Fixtures\DemoThemeFixtures;

/**
 * @backupGlobals disabled
 */
class PostMiddlewareTest extends MiddlewareTestCase
{
  protected function getFixtures(): array{
   return [
     new DemoAccountFixture(),
     new DemoThemeFixtures(),
     new DemoCommunityFixture(),
     new DemoCollectionFixture()
   ];
  }

  public function testPostCreate200()
  {
    $account = DemoAccountFixture::getAccount();

    $json = [
      "profile_id"    => $account->getCurrentProfile()->getId(),
      "collection_id" => DemoCollectionFixture::getCollection()->getId(),
      "content"       => "string",
      "attachments"   => [0],
      "links"         => [
        "url" => "string",
        "metadata"=> []
      ]
    ];

    return $this->requestPostCreatePut($json)->auth($account->getAPIKey())->execute()
      ->dump()
      ->expectJSONContentType()
      ->expectStatusCode(200)
      ->expectJSONBody(['success' => TRUE])
     ;
  }

  public function testPostCreate403()
  {


    $json = [
      'profile_id'    => 0,
      'collection_id' => 0,
      'content'       => 'string',
    ];

    return $this->requestPostCreatePut($json)->execute()->expectAuthError();
  }

  protected function requestPostCreatePut(array $json): RESTRequest
  {
    return $this->request('PUT', '/protected/post/create')->setParameters($json);
  }

  protected function requestPostDelete(int $postId): RESTRequest
  {
    return $this->request('DELETE', sprintf('/protected/post/%d/delete', $postId));
  }

  protected function requestPostEditPost(int $postId, array $json): RESTRequest
  {
    return $this->request('POST', sprintf('/protected/post/%d/edit', $postId))
      ->setParameters($json);
  }

  protected function requestPostGet(int $postId): RESTRequest
  {
    return $this->request('GET', sprintf('/protected/post/%d/get', $postId));
  }

}