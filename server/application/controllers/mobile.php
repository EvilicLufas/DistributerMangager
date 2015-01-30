<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('user/userAo','userAo');
		$this->load->model('user/loginAo','loginAo');
		$this->load->model('user/userPermissionEnum','userPermissionEnum');
		$this->load->model('user/userTypeEnum','userTypeEnum');
		$this->load->model('template/companyTemplateAo','companyTemplateAo');
		$this->load->library('argv','argv');
    }
	/**
	* @view
	*/
	public function file($userId,$url1='',$url2='',$url3='')
	{
		$url = '';
		if( $url1 != '')
			$url .= '/'.$url1;
		if( $url2 != '')
			$url .= '/'.$url2;
		if( $url3 != '')
			$url .= '/'.$url3;
		if( $url == ''){
			header("Location: /$userId/company.html");
		}
		//���ݺ�׺�����Content-Type
		$pos = strripos($url,'.');
		if( $pos != false )
			$extension = strtolower(substr($url,$pos+1));
		else
			$extension = '';
		if( $extension == 'html' || $extension == 'htm' )
			header( 'Content-Type:text/html');
		else if( $extension == 'css' )
			header( 'Content-Type:text/css');
		else if( $extension == 'js' )
			header('Content-type: text/javascript');  
		else if( $extension == 'png')
			header("Content-Type: image/png");
		else if( $extension == 'gif')
			header("Content-type: image/gif");
		else 
			header('Content-type: image/jpeg');
		
		
		//���Դ���̬�ļ�
		$staticAddress = dirname(__FILE__).'/../../../static/build/mobile';
		if( file_exists($staticAddress.$url) ){
			require_once($staticAddress.$url);
			return;
		}
			
		//����ģ�徲̬�ļ�
		$companyTemplateId = $this->companyTemplateAo->getByUserId($userId);
		if( $companyTemplateId != 0 ){
			$template = $this->companyTemplateAo->get($companyTemplateId);
			$staticAddress = dirname(__FILE__).'/../../../'.$template['url'];
			if( file_exists($staticAddress.$url) ){
				require_once($staticAddress.$url);
				return;
			}
		}
		
		//����404
		show_404();
	}
	
}
