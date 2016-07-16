<?php
namespace Domain\PostAttachment\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Post\Entity\Post;
use Domain\Post\Parameters\CreatePostParameters;
use Domain\Post\Service\PostService;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Service\PostAttachmentService;
use Evenement\EventEmitterInterface;

final class PostEvents implements EventsBootstrapInterface
{
    /** @var PostService */
    private $postService;

    /** @var PostAttachmentService */
    private $attachmentService;

    public function __construct(PostService $postService, PostAttachmentService $attachmentService)
    {
        $this->postService = $postService;
        $this->attachmentService = $attachmentService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $ps = $this->postService;
        $as = $this->attachmentService;

        $ps->getEventEmitter()->on(PostService::EVENT_CREATE, function(Post $post, CreatePostParameters $parameters) use ($as, $ps) {
            array_map(function(int $postAttachmentId) use ($post, $as, $ps) {
                $postAttachment = $as->attach(
                    $post,
                    $as->getPostAttachmentById($postAttachmentId)
                );

                $ps->attachToPost($post, $postAttachment);
            }, $parameters->getAttachmentIds());
        });
        
        $ps->getEventEmitter()->on(PostService::EVENT_DELETE, function(Post $post) use ($as) {
            array_map(function(PostAttachment $postAttachment) use ($as) {
                $as->destroy($postAttachment);
            }, $post->getAttachments()->toArray());
        });
    }
}