<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('user/userTypeEnum','userTypeEnum');
		$this->load->model('user/userPermissionEnum','userPermissionEnum');
		$this->load->model('template/companyTemplateAo','companyTemplateAo');
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
		));
		
		$dataLimit = $this->argv->checkGet(array(
			array('pageIndex','option'),
			array('pageSize','option'),
		));
		
		//���Ȩ��
		$user = $this->loginAo->checkMustLogin();
		if( $user['type'] != $this->userTypeEnum->ADMIN ){
			$this->loginAo->checkMustClient(
				$this->userPermissionEnum->COMPANY_INTRODUCE
			);
		}
		
		//ִ��ҵ���߼�
		return $this->companyTemplateAo->search($dataWhere,$dataLimit);
	}
	
	/**
	* @view json
	*/
	public function get()
	{
		//����������
		$data = $this->argv->checkGet(array(
			array('companyTemplateId','require'),
		));
		$companyTemplateId = $data['companyTemplateId'];
		
		//���Ȩ��
		$this->loginAo->checkMustAdmin();
		
		//ִ��ҵ���߼�
		return $this->companyTemplateAo->get($companyTemplateId);
	}
	
	/**
	* @view json
	*/
	public function add()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('url','require'),
			array('remark','require'),
		));
		
		//���Ȩ��
		$this->loginAo->checkMustAdmin();
		
		//ִ��ҵ���߼�
		$this->companyTemplateAo->add($data);
	}
	
	/**
	* @view json
	*/
	public function del()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('companyTemplateId','require'),
		));
		$companyTemplateId = $data['companyTemplateId'];
		
		//���Ȩ��
		$this->loginAo->checkMustAdmin();
		
		//ִ��ҵ���߼�
		$this->companyTemplateAo->del($companyTemplateId);
	}
	
	/**
	* @view json
	*/
	public function mod()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('companyTemplateId','require'),
		));
		$companyTemplateId = $data['companyTemplateId'];
		
		$data = $this->argv->checkPost(array(
			array('title','require'),
			array('url','require'),
			array('remark','require'),
		));
		
		//���Ȩ��
		$this->loginAo->checkMustAdmin();
		
		//ִ��ҵ���߼�
		$this->companyTemplateAo->mod($companyTemplateId,$data);
	}
	
	
	/**
	* @view json
	*/
	public function getMyTemplate()
	{
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		return $this->companyTemplateAo->getByUserId($userId);
	}
	
	/**
	* @view json
	*/
	public function modMyTemplate()
	{
		//����������
		$data = $this->argv->checkPost(array(
			array('companyTemplateId','require'),
		));
		$companyTemplateId = $data['companyTemplateId'];
		
		//���Ȩ��
		$user = $this->loginAo->checkMustClient(
			$this->userPermissionEnum->COMPANY_INTRODUCE
		);
		$userId = $user['userId'];
		
		//ִ��ҵ���߼�
		$this->companyTemplateAo->modByUserId($userId,$companyTemplateId);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
