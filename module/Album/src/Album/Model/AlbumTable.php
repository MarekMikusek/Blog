<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-21
 * Time: 12:40
 */

namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;

class AlbumTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row){
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAlbum (Album $album)
    {
        $data = array (
            'artist' => $album ->artist,
            'title' => $album -> title,
        );
        $id = (int) $album->id;
        if ($id == 0){
            $this ->tableGateway->insert($data);
        }
        else {
            throw new \Exception("Album id does not exist");
        }
    }

    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(['id'=> (int) $id]);
    }
}