<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('user/userPermissionEnum','userPermissionEnum');
		$this->load->model('banner/companyBannerAo','companyBannerAo');
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
		return $this->companyBannerAo->search($userId,$dataWhere,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function get()
	{
		//����������
		$data = $this->argv->checkGet(array(
			array('userCompanyBannerId','require'),
		));
		$userCompanyBannerId = $data['userCompanyBannerId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		return $this->companyBannerAo->get($userId,$userCompanyBannerId);
	}
	
	/**
	* @view json
	*/
	public function add()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('image','require'),
			array('url','require'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyBannerAo->add($userId,$data);
	}
	
	/**
	* @view json
	*/
	public function del()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyBannerId','require'),
		));
		$userCompanyBannerId = $data['userCompanyBannerId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyBannerAo->del($userId,$userCompanyBannerId);
	}
	
	/**
	* @view json
	*/
	public function mod()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyBannerId','require'),
		));
		$userCompanyBannerId = $data['userCompanyBannerId'];
		
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('image','require'),
			array('url','require'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyBannerAo->mod($userId,$userCompanyBannerId,$data);
	}
	
	/**
	* @view json
	*/
	public function moveUp()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyBannerId','require'),
		));
		$userCompanyBannerId = $data['userCompanyBannerId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyBannerAo->move($userId,$userCompanyBannerId,'up');
	}
	
	/**
	* @view json
	*/
	public function moveDown()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyBannerId','require'),
		));
		$userCompanyBannerId = $data['userCompanyBannerId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyBannerAo->move($userId,$userCompanyBannerId,'down');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
