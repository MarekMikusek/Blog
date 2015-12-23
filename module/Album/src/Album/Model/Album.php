<?php
namespace Album\Model;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Album
 * @package Album\Model
 * @ORM\Entity
 */

class Album
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;
    /**
     * @ORM\Column()
     */
    public $artist;
    /**
     * @ORM\Column
     */
    public $title;
    /**
     *
     */
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id']) ? $data['id'] : null);
        $this->artist = (!empty($data['artist']) ? $data['artist'] : null);
        $this->title = (!empty($data['title']) ? $data['title'] : null);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}