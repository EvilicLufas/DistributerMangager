<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('user/userPermissionEnum','userPermissionEnum');
		$this->load->model('article/companyArticleAo','companyArticleAo');
		$this->load->library('argv','argv');
    }
	
	/**
	* @view json
	*/
	public function search()
	{
		//����������		
		$dataWhere = $this->argv->checkGet(array(
			array('title','option'),
			array('remark','option'),
			array('userCompanyClassifyId','option')
		));
		
		$dataLimit = $this->argv->checkGet(array(
			array('pageIndex','require'),
			array('pageSize','require'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		return $this->companyArticleAo->search($userId,$dataWhere,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function getByClassifyId()
	{
		//����������
		$data = $this->argv->checkGet(array(
			array('userCompanyClassifyId','require'),
			array('userId','require'),
		));
		$userId = $data['userId'];
		$userCompanyClassifyId = $data['userCompanyClassifyId'];
		
		//ִ��ҵ���߼�
		return $this->companyArticleAo->search($userId,array('userCompanyClassifyId'=>$userCompanyClassifyId),array());
	}
	
	/**
	* @view json
	*/
	public function get()
	{
		//����������
		$data = $this->argv->checkGet(array(
			array('userCompanyArticleId','require'),
		));
		$userCompanyArticleId = $data['userCompanyArticleId'];
		
		//ִ��ҵ���߼�
		return $this->companyArticleAo->get($userCompanyArticleId);
	}
	
	/**
	* @view json
	*/
	public function add()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('cover','require'),
			array('summary','require'),
			array('remark','require'),
			array('content','require|noxss'),
			array('userCompanyClassifyId','require')
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyArticleAo->add($userId,$data);
	}
	
	/**
	* @view json
	*/
	public function del()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyArticleId','require'),
		));
		$userCompanyArticleId = $data['userCompanyArticleId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyArticleAo->del($userId,$userCompanyArticleId);
	}
	
	/**
	* @view json
	*/
	public function mod()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyArticleId','require'),
		));
		$userCompanyArticleId = $data['userCompanyArticleId'];
		
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('cover','require'),
			array('summary','require'),
			array('remark','require'),
			array('content','require|noxss'),
			array('userCompanyClassifyId','require')
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyArticleAo->mod($userId,$userCompanyArticleId,$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
