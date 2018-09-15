/**
 * Created by Administrator on 2018/5/24.
 */
var num=0;
// 初始化图表
var chart = c3.generate({
    bindto: '#real-chart',
    data: {
        json: [],
        type: 'area-spline', // line,spline,step,area,area-spline,area-step,bar,scatter,pie,donut,gauge
        labels: true
    },
    axis: {
        x: {
            type: 'timeseries',
            tick: { // 设置刻度轴
                count: 12,
                culling: {
                    max: 12
                },
                format: '%Y-%m-%d %H:%M:%S'
            }
        }
    }
});

// 生成图表数据
var metrics = ['温度', '湿度', '光照强度', '空气质量'];
var addData = (function() {
    var datas = [];
    return function(data) {
        datas.push(data);
        if (datas.length < 12) {
            chart.load({
                json: datas,
                keys: {
                    x: 'date',
                    value: metrics
                }
            });
        } else {
            chart.flow({
                json: [data],
                keys: {
                    x: 'date',
                    value: metrics
                },
                duration: 1000
            });
        }
    }
})();
//点击触发
function subTopic(){
    var topicName = document.getElementById("topicName").value;
    var topicContent = document.getElementById("topicContent").value;

    client = new Paho.MQTT.Client("localhost",Number(9001), "clientID");//建立客户端实例
    client.onConnectionLost = onConnectionLost;//注册连接断开处理事件
    client.onMessageArrived = onMessageArrived;//注册消息接收处理事件
    client.connect({onSuccess:onConnect});//连接服务器并注册连接成功处理事件

    //注册连接
    function onConnect() {
        console.log("onConnected");
        client.subscribe(topicName);//订阅主题
        message = new Paho.MQTT.Message("hello");
        message.destinationName = "hello";
        client.send(message);
    }

    //注册断开连接函数
    function onConnectionLost(responseObject) {
        console.log("注册连接断开处理事件");
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:"+responseObject.errorMessage);
            console.log("连接已断开");
        }
    }

    //注册接受成功回调函数
    function onMessageArrived(message) {
        num++;
        console.log("注册消息接收处理事件");
        console.log(message);
        console.log("收到消息:"+message.payloadString);
        console.log("收到主题:"+message.destinationName);
        document.getElementById("topicContent").value = message.payloadString;
        var li=document.createElement("li");
        li.innerHTML=""+num+".发送的主题："+topicName+"收到的内容："+message.payloadString+"";
        var element=document.getElementById('topicUl');
        element.appendChild(li);
        var msg = JSON.parse(message.payloadString);
        var data = {
            date: new Date(),
            光强: Math.floor(msg.photosensitive)
        };
        addData(data);
    }
}

function pubTopic(){
    /*clearInterval(timeId);*/
    var timeId=null;
    var topicName = 'led';
    var topicPub=document.getElementById("topicPub").value;
    // Create a client instance
    client = new Paho.MQTT.Client("localhost", Number(9001), "clientId2");

    // set callback handlers
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    // connect the client
    client.connect({
        onSuccess: onConnect
    });


    // called when the client connects
    function onConnect() {
        // Once a connection has been made, make a subscription and send a message.
        console.log("onConnect");
        message = new Paho.MQTT.Message(topicPub);
        message.destinationName = topicName;
        client.send(message);
    }

    // called when the client loses its connection
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:" + responseObject.errorMessage);
        }
    }

    // called when a message arrives
    function onMessageArrived(message) {
        console.log("onMessageArrived:" + message.payloadString);
    }
}