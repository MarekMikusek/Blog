<?php
namespace Blog\Model;


use Doctrine\ORM\Mapping as ORM;
use Blog\Model\Post;

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
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    public $post;

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
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }


//
//    public function exchangeArray($data)
//    {
//        $this->id = (!empty($data['id']) ? $data['id'] : null);
//        $this->artist = (!empty($data['artist']) ? $data['artist'] : null);
//        $this->title = (!empty($data['title']) ? $data['title'] : null);
//    }


}