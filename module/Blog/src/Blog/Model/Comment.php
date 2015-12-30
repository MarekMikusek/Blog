<?php
namespace Blog\Model;


use Doctrine\ORM\Mapping as ORM;
use Blog\Model\Blog;

/**
 * Class Album
 * @package Album\Model
 * @ORM\Entity
 */
class Comment
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
    public $content;

    /**
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    public $blog;

    /**
     *
     */
    protected $inputFilter;

    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * @param mixed $blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }


//
//    public function exchangeArray($data)
//    {
//        $this->id = (!empty($data['id']) ? $data['id'] : null);
//        $this->artist = (!empty($data['artist']) ? $data['artist'] : null);
//        $this->title = (!empty($data['title']) ? $data['title'] : null);
//    }


}