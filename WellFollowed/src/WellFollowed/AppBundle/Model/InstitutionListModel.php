<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 29/12/2015
 * Time: 18:14
 */

namespace WellFollowed\AppBundle\Model;


use WellFollowed\AppBundle\Model\Common\ListModel;

class InstitutionListModel extends ListModel
{
    private $type;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}