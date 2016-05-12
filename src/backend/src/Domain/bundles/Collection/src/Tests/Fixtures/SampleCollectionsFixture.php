<?php
namespace Domain\Collection\Tests\Fixtures;

use Application\PHPUnit\Fixture;
use Doctrine\ORM\EntityManager;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Community\Tests\Fixtures\SampleCommunitiesFixture;
use Domain\Theme\Tests\Fixtures\SampleThemesFixture;
use Zend\Expressive\Application;

class SampleCollectionsFixture implements Fixture
{
    private static $profileCollections;
    private static $communityCollections;

    public function up(Application $app, EntityManager $em)
    {
        $collectionService = $app->getContainer()->get(CollectionService::class); /** @var CollectionService $collectionService */

        self::$profileCollections = [
            1 => $collectionService->createProfileCollection(
                new CreateCollectionParameters('Profile Collection 1', 'My Profile Collection 1', SampleThemesFixture::getTheme(1)->getId())
            ),
            2 => $collectionService->createProfileCollection(
                new CreateCollectionParameters('Profile Collection 1', 'My Profile Collection 2', SampleThemesFixture::getTheme(2)->getId())
            ),
            3 => $collectionService->createProfileCollection(
                new CreateCollectionParameters('Profile Collection 1', 'My Profile Collection 3', SampleThemesFixture::getTheme(3)->getId())
            ),
            4 => $collectionService->createProfileCollection(
                new CreateCollectionParameters('Profile Collection 1', 'My Profile Collection 4', SampleThemesFixture::getTheme(4)->getId())
            ),
            5 => $collectionService->createProfileCollection(
                new CreateCollectionParameters('Profile Collection 1', 'My Profile Collection 5', SampleThemesFixture::getTheme(5)->getId())
            ),
        ];

        self::$communityCollections = [
            1 => $collectionService->createCommunityCollection(
                SampleCommunitiesFixture::getCommunity(1)->getId(),
                new CreateCollectionParameters('Community Collection 1', 'My Community Collection 1', SampleThemesFixture::getTheme(1)->getId())
            ),
            2 => $collectionService->createCommunityCollection(
                SampleCommunitiesFixture::getCommunity(2)->getId(),
                new CreateCollectionParameters('Community Collection 2', 'My Community Collection 2', SampleThemesFixture::getTheme(2)->getId())
            ),
            3 => $collectionService->createCommunityCollection(
                SampleCommunitiesFixture::getCommunity(3)->getId(),
                new CreateCollectionParameters('Community Collection 3', 'My Community Collection 3', SampleThemesFixture::getTheme(3)->getId())
            ),
            4 => $collectionService->createCommunityCollection(
                SampleCommunitiesFixture::getCommunity(4)->getId(),
                new CreateCollectionParameters('Community Collection 4', 'My Community Collection 4', SampleThemesFixture::getTheme(4)->getId())
            ),
            5 => $collectionService->createCommunityCollection(
                SampleCommunitiesFixture::getCommunity(5)->getId(),
                new CreateCollectionParameters('Community Collection 5', 'My Community Collection 5', SampleThemesFixture::getTheme(5)->getId())
            ),
        ];
    }

    public static function getProfileCollections(): array
    {
        return self::$profileCollections;
    }

    public static function getProfileCollection(int $index): Collection
    {
        return self::$profileCollections[$index];
    }

    public static function getCommunityCollections(): array
    {
        return self::$communityCollections;
    }

    public static function getCommunityCollection(int $index): Collection
    {
        return self::$communityCollections[$index];
    }
}