<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class adddataController extends Controller {
    //构造函数中调用方法
    public function __construct() {
//        echo "nihao";
//        exit();
        $this->receive();
    }
    //接收消息
    function receive() {
        //定义主题
        $sub_zhuti = "light";

        //连接MQTT服务器
        // 订阅信息,接收一个信息后退出
        $server = "192.168.11.149";     // 服务代理地址(mqtt服务端地址)
        $port = 1883;                     // 通信端口
        $username = "";                   // 用户名(如果需要)
        $password = "";                   // 密码(如果需要
        $client_id = "clientx9293670xxctr"; // 设置你的连接客户端id

        $this->library('phpMQTT');

        $mqtt = new phpMQTT($server, $port, $client_id);

        if(!$mqtt->connect(true, NULL, $username, $password)) { //链接不成功再重复执行监听连接
            exit(1);
        }
        $topics[$sub_zhuti] = array("qos" => 0, "function" => "procmsg");
        ///////////////////////////////////////////////////////////////////////////
        //创建一个node模型对象
        $nodeModel = new NodeModel('photosensitive');
        //写一个死循环
        while(1) {
            // 订阅主题为 data qos为0
            $mqtt->subscribe($topics, 0);
            //死循环监听
            while(!($msg = $mqtt->proc())){

            }
            //打印消息

            $data = $this->handleMsg($msg);
            echo $data;
            exit();
            $z = $nodeModel->insert($data);
            if($z){
                echo "已插入数据库。";
            }
            $mqtt->close();
        }
        
    }
    //对$msg进行处理
    function handleMsg($msg){
        
        //将字符串转换成数组形式
        //$res_temp = explode(',', $msg);
        $res_tmp = json_decode($msg, TRUE);
//        $res['node_num'] = $res_tmp['id'];
        $res['photosensitive'] = $res_tmp['photosensitive'];
        $res['time'] = time();
//        var_dump($res);
//        exit;
        return $res;
    }
}
new adddataController();