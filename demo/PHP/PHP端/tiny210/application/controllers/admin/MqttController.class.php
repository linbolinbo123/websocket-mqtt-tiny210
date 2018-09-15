<?php
//商品分类模块控制器
class MqttController extends BaseController{
    ////////////////////////////////////////////////////////////////////////////
    //发布命令操作
    function pubcmdAction() {
        //获取showlist页面上传上来的参数
        $cmd = $_GET['cmd'];
        $zhuti = "led";

//        echo $content;
//        exit;
//        echo $cmd;
//        echo $node_num;
        // 发送给订阅号信息,创建socket,无sam队列
        $this->library('phpMQTT');
        $server = "192.168.137.2";     // 服务代理地址(mqtt服务端地址)
        $port = 1883;                     // 通信端口
        $username = "";                   // 用户名(如果需要)
        $password = "";                   // 密码(如果需要
        $client_id = uniqid(); // 设置你的连接客户端id
        $mqtt = new phpMQTT($server, $port, $client_id); //实例化MQTT类
        if ($mqtt->connect(true, NULL, $username, $password)) {
            //如果创建链接成功
            $mqtt->publish($zhuti, $cmd, 0);
            // 发送到 xxx3809293670ctr 的主题 一个信息 内容为 setr=3xxxxxxxxx Qos 为 0 
            $mqtt->close();    //发送后关闭链接
            $this->jump("index.php?p=admin&c=mqtt&a=showcmdlist",'发送命令成功');
        } else {
            echo "Time out!\n";
        }
    }
    
    //显示vlc页面，进行监控
    function vlcAction() {
        include CUR_VIEW_PATH."vlc.html";
    }
    

    //////////////////////////////////////////////////////////////////////////
    //导入显示备选的节点的页面
    function selectednodeAction() {
        //载入视图模板
        include CUR_VIEW_PATH.'selectednode.html';
    }
    
    
    /////////////////////////////////////////////////////////////////////////
    //展示数据并调用添加数据函数，获取底层上传上来的数据
    function showlistAction() {
        //调用添加函数 获取底层上传上来的数据
        //$this->adddataAction();
        //获取传过来的flag值，进行判断，显示哪个节点的数据
//        $flag = $_GET['flag'];
        //获取所有的temp表中数据
        //1.实例化node对象
        $nodeModel = new NodeModel('temp');
        //2.获取所有的light数据
        $node_light = $nodeModel->getTemps();
        //载入视图模板
        include CUR_VIEW_PATH."showlist.html";
        
    }
    //接收消息
    function adddataAction() {
        //定义主题
        $sub_zhuti = "data";
        $i = 5;

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
        $nodeModel = new NodeModel('temp');
        //写一个循环，持续不断接收数据
        while($i){
            // 订阅主题为 data qos为0
            $mqtt->subscribe($topics, 0);
            //死循环监听
            while(!($msg = $mqtt->proc())){

            }
            //打印消息

            $data = $this->handleMsg($msg);
            $nodeModel->insert($data);
            $i--;
        }
        $mqtt->close();
    }
    //////////////////////////////////////////////////////////////////////////////
    //对$msg进行处理
    function handleMsg($msg){
        
        //将字符串转换成数组形式
        //$res_temp = explode(',', $msg);
        $res_tmp = json_decode($msg, TRUE);
        $res['node_num'] = $res_tmp['id'];
        $res['node_data'] = $res_tmp['value'];
        $res['node_time'] = time();
//        var_dump($res);
//        exit;
        return $res;
    }

    //页面上打印相关数据
    function procmsg($topic, $msg){ //信息回调函数 打印信息
        echo "Msg Recieved: " . date("r") . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
        //$xxx = json_decode($msg);
        //var_dump($xxxxxx->aa);
        die;
    }
    
    //查看光敏数据页面
    function photosensitiveAction() {
        //获取光敏数据
        $photosensitiveModel = new PhotosensitiveModel('photosensitive');
        $photosensitives = $photosensitiveModel->getPhotosensitives();
//        var_dump($photosensitives);
//        exit();
        //导入视图模板
        include CUR_VIEW_PATH."photosensitive.html";
    }
    
    //查看命令列表
    function showcmdlistAction() {
        
        include CUR_VIEW_PATH."cmdlist.html";
    }

}

?>