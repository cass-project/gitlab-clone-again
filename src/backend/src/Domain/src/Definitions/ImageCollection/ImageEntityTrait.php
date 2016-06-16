<?php
namespace Domain\Definitions\ImageCollection;

trait ImageEntityTrait
{
    /**
     * @Column(type="json_array")
     * @var array
     */
    private $image = [];

    public function fetchImages(): ImageCollection
    {
        return ImageCollection::createFromJSON($this->image);
    }

    public function exportImages(ImageCollection $images): self
    {
        $this->image = $images->toJSON();

        return $this;
    }
}