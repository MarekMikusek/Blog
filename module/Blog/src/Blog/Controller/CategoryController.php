<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-23
 * Time: 12:34
 */

namespace Blog\Controller;

use Doctrine\ORM\Mapping as ORM;


class CategoryController extends AbstractActionController
{



    public function addAction(){

    }

    public function editAction(){

    }

    public function deleteAction(){

    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}