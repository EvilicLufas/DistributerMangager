<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LuckyDraw extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('client/clientLoginAo','clientLoginAo');
		$this->load->model('luckydraw/luckyDrawAo','luckyDrawAo');
		$this->load->model('luckydraw/luckyDrawStateEnum','luckyDrawStateEnum');
		$this->load->model('luckydraw/luckyDrawTypeEnum','luckyDrawTypeEnum');
		$this->load->model('luckydraw/luckyDrawMethodEnum','luckyDrawMethodEnum');
		$this->load->library('argv','argv');
    }
	
	/**
	* @view json
	*/
	public function getAllType()
	{
		return $this->luckyDrawTypeEnum->names;
	}

	/**
	* @view json
	*/
	public function getAllState()
	{
		return $this->luckyDrawStateEnum->names;
	}
	
	/**
	* @view json
	*/
	public function search()
	{
		//检查输入参数		
		$dataWhere = $this->argv->checkGet(array(
			array('title','option'),
			array('summary','option'),
			array('state','option'),
		));
		
		$dataLimit = $this->argv->checkGet(array(
			array('pageIndex','require'),
			array('pageSize','require'),
		));
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		return $this->luckyDrawAo->search($userId,$dataWhere,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function get()
	{
		//检查输入参数
		$data = $this->argv->checkGet(array(
			array('luckyDrawId','require'),
		));
		$luckyDrawId = $data['luckyDrawId'];
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		return $this->luckyDrawAo->get($userId,$luckyDrawId);
	}
	
	/**
	* @view json
	*/
	public function add()
	{
		//检查输入参数
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('method','require'),
			array('summary','require'),
			array('state','require'),
			array('beginTime','require'),
			array('endTime','require'),
			array('commodity','option',array()),
		));
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		$this->luckyDrawAo->add($userId,$data);
	}
	
	/**
	* @view json
	*/
	public function del()
	{
		//检查输入参数
		$data = $this->argv->checkPost(array(
			array('luckyDrawId','require'),
		));
		$luckyDrawId = $data['luckyDrawId'];
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		$this->luckyDrawAo->del($userId,$luckyDrawId);
	}
	
	/**
	* @view json
	*/
	public function mod()
	{
		//检查输入参数
		$data = $this->argv->checkPost(array(
			array('luckyDrawId','require'),
		));
		$luckyDrawId = $data['luckyDrawId'];
		
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('method','require'),
			array('summary','require'),
			array('state','require'),
			array('beginTime','require'),
			array('endTime','require'),
			array('commodity','option',array()),
		));
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		$this->luckyDrawAo->mod($userId,$luckyDrawId,$data);
	}

	/**
	* @view json
	*/
	public function getResult()
	{
		//检查输入参数
		$data = $this->argv->checkGet(array(
			array('luckyDrawId','require'),
		));
		$luckyDrawId = $data['luckyDrawId'];

		$dataLimit = $this->argv->checkGet(array(
			array('pageIndex','require'),
			array('pageSize','require'),
		));
		
		//检查权限
		$user = $this->loginAo->checkMustClient(
            $this->userPermissionEnum->COMPANY_SHOP
        );
        $userId = $user['userId'];
		
		//执行业务逻辑
		return $this->luckyDrawAo->getResult($userId,$luckyDrawId,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function draw()
	{
		//检查输入参数
		$data = $this->argv->checkPost(array(
			array('userId','require'),
			array('luckyDrawId','require'),
			array('name','require'),
			array('phone','require'),
		));
		
		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);
		
		//执行业务逻辑
		return $this->luckyDrawAo->luckyDraw(
			$data['userId'],
			$client['clientId'],
			$data['luckyDrawId'],
			$data['name'],
			$data['phone']
		);
	}
	
	/**
	* @view json
	*/
	public function shakeDraw()
	{
		//检查输入参数
		$data = $this->argv->checkPost(array(
			array('userId','require'),
			array('luckyDrawId','require'),
		));
		
		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);
		
		//执行业务逻辑
		return $this->luckyDrawAo->luckyDraw(
			$data['userId'],
			$client['clientId'],
			$data['luckyDrawId'],
			'',
			'',		
			false
		);
	}

	/**
	* @view json
	*/
	public function getClientResult()
	{
		//检查输入参数
		$data = $this->argv->checkGet(array(
			array('userId','require'),
			array('luckyDrawId','require'),
		));
		
		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);
		
		//执行业务逻辑
		return $this->luckyDrawAo->getClientResult(
			$data['userId'],
			$client['clientId'],
			$data['luckyDrawId']
		);
	}

	/**
	* @view json
	*/
	public function getClientAllResult()
	{
		//检查输入参数
		$data = $this->argv->checkGet(array(
			array('userId','require'),
		));
		
		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);
		
		//执行业务逻辑
		return $this->luckyDrawAo->getClientAllResult(
			$data['userId'],
			$client['clientId']
		);
	}

	/**
	 * @view json
	 * 判断合理性
	 */
	public function judge(){
		if($this->input->is_ajax_request()){
			$card_id = $this->input->post('card_id');
			$list_id = $this->input->post('list_id');
			return $this->luckyDrawAo->judge($list_id);
		}
	}

	/**
	 * @view json
	 */
	public function getLuckyMethod(){
		return $this->luckyDrawMethodEnum->names;
	}


	/**
	 * @view json
	 * 统计抽奖次数
	 */
	public function drawCount(){
		if($this->input->is_ajax_request()){
			$luckyDrawId = $this->input->get('luckyDrawId');
			return $this->luckyDrawAo->drawCount($luckyDrawId);
		}
	}

	/**
	 * @view json
	 * 修改用户姓名 和 手机号码
	 */
	public function modUserInfo(){
		//检查输入参数
		$data = $this->argv->checkGet(array(
			array('userId','require'),
		));
		
		//检查权限
		$clientId= $this->clientLoginAo->checkMustLogin($data['userId'])['clientId'];

		if($this->input->is_ajax_request()){
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$luckyDrawId = $this->input->post('luckyDrawId');
			return $this->luckyDrawAo->modUserInfo($name,$phone,$luckyDrawId,$clientId);
		}
	}

	/**
	 * @view json
	 * 给抽奖前端显示其他中奖用户
	 */
	 public function winningList(){
	 	//检查输入参数
		$data = $this->argv->checkPost(array(
			array('userId','require'),
			array('luckyDrawId','require'),
		));

		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);

		//$sql="select t_client.nickName,t_client.headImgUrl,title from t_lucky_draw_client left join t_client on t_lucky_draw_client.clientId=t_client.clientId where luckyDrawId='".$data['luckyDrawId']."' order by luckyDrawClientId desc limit 10;";
		$sql="select t_client.nickName,t_client.headImgUrl,title from t_lucky_draw_client left join t_client on t_lucky_draw_client.clientId=t_client.clientId where luckyDrawId='".$data['luckyDrawId']."' and nickName not like ''  and title!='谢谢参与' order by luckyDrawClientId desc limit 10;";
		$data = $this->db->query($sql)->result_array();

		foreach($data as $k=>$v ){
			$data[$k]['nickName'] =  base64_decode($data[$k]['nickName'] );		
		}

		return $data;
	 }

	 /**
	  * @view json
	  * 判断活动是否结束
	  */
	 public function judgeEnd(){
	 	//检查输入参数
		$data = $this->argv->checkGet(array(
			array('userId','require'),
			array('luckyDrawId','require'),
		));
		//检查权限
		$client = $this->clientLoginAo->checkMustLogin($data['userId']);

		$userId = $data['userId'];
		$luckyDrawId = $data['luckyDrawId'];
		$clientId = $client['clientId'];
		return $this->luckyDrawAo->judgeEnd($userId,$clientId,$luckyDrawId);
	 }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
