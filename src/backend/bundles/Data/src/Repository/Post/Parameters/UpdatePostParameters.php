<?php

namespace Data\Repository\Post\Parameters;


use Common\Tools\RequestParams\Param;
use Data\Repository\Post\SavePostProperties;

class UpdatePostParameters implements SavePostProperties
{

	private $id;

	private $name;
	private $description;
	private $status;

	public function __construct(Param $name, Param $description, Param $status, Param $id){
		$this->id          = $id;
		$this->name        = $name;
		$this->description = $description;
		$this->status      = $status;
	}

	public function getId():Param
	{
		return $this->id;
	}

	public function getName():Param
	{
		return $this->name;
	}

	public function getDescription():Param
	{
		return $this->description;
	}

	public function getPublish():Param
	{
		return $this->status;
	}

	public function getAccountId():Param
	{
		return new Param(['account_id'], 'account_id');
	}

	public function getCreated():Param{
		return new Param(null,'created');
	}

	public function getUpdated():Param{
		$updated['updated'] = new \DateTime();
		return new Param($updated, 'updated');
	}


}