<?php
namespace Data\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @Entity(repositoryClass="Data\Repository\Attachment\AttachmentRepository")
 * @Table(name="attachment")
 */
class Attachment
{
	const TYPE_VIDEO_LINK = 1;

	/**
	 * @Id()
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $id;

	/**
	 * @type
	 * @Column(type="integer")
	 */
	private $type;

	/**
	 * @ManyToOne(targetEntity="Data\Entity\Post", inversedBy="attachments")
	 * @JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $post_id;

	/**
	 * @Column(type="string")
	 */
	private $content;
	/**
	 * @Column(type="datetime")
	 */
	private $created;
	/**
	 * @Column(type="datetime")
	 */
	private $updated;


	public function getType():int
	{
		return $this->type;
	}


	public function setType(int $type)
	{
		$this->type = $type;
		return $this;
	}


	public function getPost():Post
	{
		return $this->post_id;
	}


	public function setPost(Post $post_id)
	{
		$this->post_id = $post_id;
		return $this;
	}


	public function getContent()
	{
		return $this->content;
	}


	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}


	public function getCreated():\DateTime
	{
		return $this->created;
	}


	public function setCreated(\DateTime $created)
	{
		$this->created = $created;
		return $this;
	}


	public function getUpdated():\DateTime
	{
		return $this->updated;
	}

	public function setUpdated(\DateTime $updated)
	{
		$this->updated = $updated;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id){
		$this->id = $id;
	}

	public function toJSON()
	{
		return [
			'id'      => $this->getId(),
			'type'    => $this->getType(),
			'post_id' => $this->getPost()->getId(),
			'content' => $this->getContent(),
			'created' => $this->getCreated()->format("Y-m-d H:i:s"),
			'updated' => $this->getUpdated()->format("Y-m-d H:i:s"),
		];
	}

}