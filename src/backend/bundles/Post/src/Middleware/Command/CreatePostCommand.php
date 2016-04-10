<?php
namespace Post\Middleware\Command;


use Common\Tools\RequestParams\Param;
use Post\Middleware\Request\PutPostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreatePostCommand extends Command
{

	public function run(ServerRequestInterface $request){
		$postService= $this->getPostService();

		$account = $this->getCurrentProfileService()->getCurrentAccount();
		$accountIdParam = new Param(['account_id'=>$account->getId()], 'account_id');

		$post = $postService->create(
			(new PutPostRequest($request))
															->getParameters()
															->setAccountId($accountIdParam)
															->setPublish(new Param(['publish'=> 'true'],'publish'))
		);

		return [
			'id' => $post->getId(),
			'entity'=> $post->toJSON()
		];
	}
}