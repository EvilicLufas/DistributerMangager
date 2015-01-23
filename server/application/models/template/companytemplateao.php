<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanyTemplateAo extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('template/companyTemplateDb','companyTemplateDb');
		$this->load->model('template/companyTemplateClassifyDb','companyTemplateClassifyDb');
	}
	
	public function search($dataWhere,$dataLimit){
		return $this->companyTemplateDb->search($dataWhere,$dataLimit);
	}
	
	public function get($companyTemplateId){
		$template = $this->companyTemplateDb->get($companyTemplateId);
		
		$template['classify'] = $this->companyTemplateClassifyDb->getByCompanyTemplateId($companyTemplateId);
		
		return $template;
	}
	
	public function del($companyTemplateId){
		$this->companyTemplateDb->del($companyTemplateId);
			
		$this->companyTemplateClassifyDb->delByCompanyTemplateId($companyTemplateId);
	}
	
	public function add($data){
		//���ģ�������Ϣ
		$templateBaseInfo = $data;
		unset($templateBaseInfo['classify']);
		$companyTemplateId = $this->companyTemplateDb->add($templateBaseInfo);
		
		//���ģ�������Ϣ
		if( isset($data['classify']) ){
			$templateClassifyInfo = __::map($data['classify'],function($single)use($companyTemplateId){
				return array(
					'companyTemplateId'=>$companyTemplateId,
					'title'=>$single['title'],
				);
			});
			$this->companyTemplateClassifyDb->addBatch($templateClassifyInfo);
		}
	}
	
	public function mod($companyTemplateId,$data){
		//�޸�ģ�������Ϣ
		$templateBaseInfo = $data;
		unset($templateBaseInfo['classify']);
		$this->companyTemplateDb->mod($companyTemplateId , $templateBaseInfo);
			
		//�޸�ģ�������Ϣ
		if( isset($data['classify']) ){
			$oldTemplateClassifyInfo = array();
			$newTemplateClassifyInfo = array();
			foreach( $data['classify'] as $single ){
				if( $single['companyTemplateClassifyId'] != '')
					$oldTemplateClassifyInfo[] = array(
						'companyTemplateClassifyId'=>$single['companyTemplateClassifyId'],
						'companyTemplateId'=>$companyTemplateId,
						'title'=>$single['title'],
					);
				else
					$newTemplateClassifyInfo[] = array(
						'companyTemplateId'=>$companyTemplateId,
						'title'=>$single['title'],
					);
			}
			$this->companyTemplateClassifyDb->delByCompanyTemplateId($companyTemplateId);
			$this->companyTemplateClassifyDb->addBatch($oldTemplateClassifyInfo);
			$this->companyTemplateClassifyDb->addBatch($newTemplateClassifyInfo);
		}
	}
}
