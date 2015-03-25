<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderStatisticAo extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->model('order/orderDb', 'orderDb');
        $this->load->model('order/orderStateEnum', 'orderStateEnum');
	$this->load->model('shop/commodityAo', 'commodityAo');
    }

    private function formatTime($timeStr){
        $time = strtotime($timeStr);
        return date('Y-m-d', $time);
    }

    public function getOrderDayStatistic($userId, $beginTime, $endTime){
        $where['$userId'] = $userId;
        if($beginTime != '')
            $where['beginTime'] = $beginTime;
        if($endTime != '')
            $where['endTime'] = $endTime;

        $ret = $this->orderDb->search($where, array());
        $data = $ret['data'];
        $retData = array();
        foreach($data as $order){
            if( !isset($retData[ $this->formatTime($order['createTime']) ])){
                $retData[ $this->formatTime($order['createTime']) ] = array(
                    'day'=>$this->formatTime($order['createTime']),
                    'orderNum'=>1,
                    'orderPrice'=>$this->commodityAo->getFixedPrice($order['price'])
                );
            }else{
                $retData[ $this->formatTime($order['createTime']) ]['orderNum'] ++;
                $retData[ $this->formatTime($order['createTime']) ]['orderPrice'] += $this->commodityAo->getFixedPrice($order['price']);
            }
        }

        $ret = array();
        if($endTime == '')
            $endTime = min(array_keys($retData));
        if($beginTime == '')
            $beginTime = max(array_keys($retData));

        $time = $endTime;
        while($time >= $beginTime){
            if( isset($retData[$time]) ){
                $ret[] = $retData[$time];
            }else{
                $ret[] = array(
                    'day'=>$time,
                    'orderNum'=>0,
                    'orderPrice'=>0
                );
            }
            $time = date('Y-m-d', strtotime($time . ' -1 day'));
        }

        return $ret;
    }

    public function getOrderTotalStatistic($userId, $limit){
            $where = array(
                'userId'=>$userId
            );    
            $data = array();
            foreach($this->orderStateEnum->enums as $singleEnum){
                $where['state'] = $singleEnum[0];
                $retData = $this->orderDb->search($where, $limit);
                $orderPrice = 0;
                foreach($retData['data'] as $order)
                    $orderPrice += $order['price'];
                $data[] = array(
                    'state'=>$singleEnum[0],
                    'stateName'=>$singleEnum[2],
                    'num'=>$retData['count'],
                    'price'=>$orderPrice
                );
            }
            return $data;
    }

}
