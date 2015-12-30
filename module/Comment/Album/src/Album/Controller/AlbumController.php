<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-21
 * Time: 11:55
 */

namespace Album\Controller;

use Album\Form\AlbumForm;
use Album\Model\Album;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

    protected $albumTable;

    public function createForm()
    {
        $form = new AlbumForm();
        $form->setHydrator(new ClassMethods())
            ->setObject(new Album());
        $album = new Album();

        return $form;
    }

    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->getEntityManager()->getRepository('Album\Model\Album')->findAll()
        ]);
    }

    public function addAction()
    {
//        $form = new AlbumForm();
//        $form->setHydrator(new ClassMethods())
//            ->setObject(new Album());
        $form = $this->createForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->persist($form->getData());
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', [
                'action' => 'add',
            ]);
        }
        try {
            $album = $this->getEntityManager()->getRepository('Album\Model\Album')->find($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('album', [
                'action' => 'index'
            ]);
        }
        $form = $this->createForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('album');
            }
        }
        return [
            'id' => $id,
            'form' => $form,
        ];
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost('id');
                $album= $this->getEntityManager()->getRepository('Album\Model\Album')->find($id);
                $this->getEntityManager()->remove($album);
                $this->getEntityManager()->flush($album);
            }
            return $this->redirect()->toRoute('album');
        }
        return [
            'id' => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        ];
    }

    /**
     * @return \Album\Model\AlbumTable
     */
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}