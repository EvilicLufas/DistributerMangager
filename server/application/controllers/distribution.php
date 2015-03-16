<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distribution extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('user/loginAo', 'loginAo');
        $this->load->model('client/clientLoginAo', 'clientLoginAo');
        $this->load->model('distribution/distributionAo', 'distributionAo');
        $this->load->model('distribution/distributionstateEnum', 'distributionStateEnum');
        $this->load->library('argv', 'argv');
    }

    /**
     * @view json
     */
    public function search(){
        //检查参数
        $dataWhere = $this->argv->checkGet(array(
            array('direction', 'require')
        ));

        $dataLimit = $this->argv->checkGet(array(
            array('pageIndex', 'require'),
            array('pageSize', 'require')
        ));

        //检查权限
        $user = $this->loginAo->checkMustLogin();

        if($dataWhere['direction'] == 'up')
            $where = array(
                'upUserId'=>$user['userId']
            );
        else if($dataWhere['direction'] == 'down')
            $where = array(
                'downUserId'=>$user['userId']
            );
        return $this->distributionAo->search($where, $dataLimit);
    }

    /**
     * @view json
     */
    public function get(){
        //检查参数
        $dataWhere = $this->argv->checkGet(array(
            array('distributionId', 'require')
        ));
        
        //检查权限
        $user = $this->loginAo->checkeMustLogin();

        $distribution = $this->distributionAo->get($user['userId'], $distributionId);
        $upUser = $this->loginAo->get($distribution['upUserId']);
        $downUser = $this->loginAo->get($distribution['downUserId']);
        $distribution['upUserCompany'] = $upUser['company'];
        $distribution['downUserCompany'] = $downUser['company'];
        return $distribution;
    }

    /**
     * @view json
     */
    public function request(){
        //检查参数
        $data = $this->argv->checkPost(array(
            array('upUserId', 'require')
        ));

        //检查权限
        $user = $this->loginAo->checkMustLogin();

        $data = array(
            'state'=>$this->distributionStateEnum->ON_REQUEST
        );

        $this->distributionAo->add($data['upUserId'], $user['userId'], $data);
    } 

    /**
     * @view json
     */
    public function accept(){
        //检查参数
        $data = $this->argv->checkPost(array(
            array('distributionId', 'require'),
            array('distributionPercent' 'require')
        ));
        
        //检查权限
        $user = $this->loginAo->checkMustLogin();

        $distribution = $this->distributionAo->get($user['userId'], $data['distributionId']);
        if($distribution['upUserId'] != $user['userId'])
            throw new CI_MyException(1, "没有相应的分成关系请求");
        $acceptData = array(
            'state'=>$this->distributionStateEnum->ON_ACCEPT,
            'distributionPercent'=>$data['distributionPercent']
        );

        $this->distributionAo->mod($distribution['distributionId'], 
            $acceptData);
    }

    /**
     * @view json
     */
    public function mod(){
        $data = $this->argv->checkPost(array(
            array('distributionId', 'require'),
            array('distributionPercent', 'require')
        ));
        
        $distributionId = $data['distributionId'];
        unset($data['distributionId']);
        $this->distributionAo->mod($distributionId, $data);
    }

    /**
     * @view json
     */
    public function del(){
        //检查参数
        $data = $this->argv->checkPost(array(
            array('distributionId', 'require')
        ));

        //检查权限
        $user = $this->loginAo->checkMustLogin();
        $userId = $user['userId'];

        $this->distributionAo->del($userId, $data['distributionId']);
    }

    /**
     * @view json
     */
    public function getLink(){
        //检查参数
        $data = $this->argv->checkGet(array(
            array('upUserId', 'require'),
            array('downUserId', 'require')
        ));

        return $this->distributionAo->getLink($data['upUserId'], $data['downUserId']);
    }
}
