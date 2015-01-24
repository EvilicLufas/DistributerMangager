<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classify extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('user/userPermissionEnum','userPermissionEnum');
		$this->load->model('classify/companyClassifyAo','companyClassifyAo');
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
			array('remark','option')
		));
		
		$dataLimit = $this->argv->checkGet(array(
			array('pageIndex','option'),
			array('pageSize','option'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		return $this->companyClassifyAo->search($userId,$dataWhere,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function get()
	{
		//����������
		$data = $this->argv->checkGet(array(
			array('userCompanyClassifyId','require'),
		));
		$userCompanyClassifyId = $data['userCompanyClassifyId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		return $this->companyClassifyAo->get($userId,$userCompanyClassifyId);
	}
	
	/**
	* @view json
	*/
	public function add()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('remark','require'),
			array('icon','require'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyClassifyAo->add($userId,$data);
	}
	
	/**
	* @view json
	*/
	public function del()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyClassifyId','require'),
		));
		$userCompanyClassifyId = $data['userCompanyClassifyId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyClassifyAo->del($userId,$userCompanyClassifyId);
	}
	
	/**
	* @view json
	*/
	public function mod()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('userCompanyClassifyId','require'),
		));
		$userCompanyClassifyId = $data['userCompanyClassifyId'];
		
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('remark','require'),
			array('icon','require'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyClassifyAo->mod($userId,$userCompanyClassifyId,$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
