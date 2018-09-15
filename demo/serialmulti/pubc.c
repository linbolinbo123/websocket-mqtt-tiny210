#include "stdio.h"
#include "stdlib.h"
#include "string.h"
#include "MQTTAsync.h"
#include <unistd.h>
#include <errno.h>
#include <signal.h>
#include "cssl.h"
#include "cJSON.h"

#define ADDRESS     "172.20.10.14" 
#define CLIENTID    "MYCLIENT"
#define TOPIC       "light"
#define STOPIC       "led"
#define QOS         1
#define TIMEOUT     10000L

volatile MQTTAsync_token deliveredtoken;
int disc_finished = 0;
int subscribed = 0;
int finished = 0;
cssl_t *ser;

char ledc[8][8]={
0x7E ,0x42 ,0xC1 ,0x00 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x01 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x02 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x03 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x04 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x05 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x06 ,0x00 ,0x00 ,0x00 ,0x7E,
0x7E ,0x42 ,0xC1 ,0x07 ,0x00 ,0x00 ,0x00 ,0x7E};

///
void onSubscribeFailure(void* context, MQTTAsync_failureData* response)
{
	printf("Subscribe failed, rc %d\n", response ? response->code : 0);
	finished = 1;
}
///
void connlost(void *context, char *cause)
{
	MQTTAsync client = (MQTTAsync)context;
	MQTTAsync_connectOptions conn_opts = MQTTAsync_connectOptions_initializer;
	int rc;

	printf("\nConnection lost\n");
	printf("     cause: %s\n", cause);

	printf("Reconnecting\n");
	conn_opts.keepAliveInterval = 20;
	conn_opts.cleansession = 1;
	if ((rc = MQTTAsync_connect(client, &conn_opts)) != MQTTASYNC_SUCCESS)
	{
		printf("Failed to start connect, return code %d\n", rc);
 		finished = 1;
	}
}

void onSubscribe(void* context, MQTTAsync_successData* response)
{
	printf("Subscribe succeeded\n");
}

void onDisconnect(void* context, MQTTAsync_successData* response)
{
	printf("Successful disconnection\n");
	finished = 1;
}


void onSend(void* context, MQTTAsync_successData* response)
{
	printf("Message with token value %d delivery confirmed\n", response->token);
}


void onConnectFailure(void* context, MQTTAsync_failureData* response)
{
	printf("Connect failed, rc %d\n", response ? response->code : 0);
	finished = 1;
}

int msgarrvd(void *context, char *topicName, int topicLen, MQTTAsync_message *message)
{
    int i;
    char* payloadptr;

    printf("Message arrived\n");
    printf(" topic: %s\n", topicName);
    printf(" message: ");

    payloadptr = message->payload;
    int ff=payloadptr[0]-'0';
    for(i=0; i<message->payloadlen; i++)
    {
        putchar(*payloadptr++);
    }
    putchar('\n');
    cssl_putdata(ser,ledc[ff],8);
    MQTTAsync_freeMessage(&message);
    MQTTAsync_free(topicName);
    return 1;
}

void onConnect(void* context, MQTTAsync_successData* response)
{
	printf("Successful connection\n");
	MQTTAsync client = (MQTTAsync)context;
	MQTTAsync_responseOptions opts = MQTTAsync_responseOptions_initializer;
	MQTTAsync_message pubmsg = MQTTAsync_message_initializer;
	int rc;

	printf("Subscribing to topic %s\nfor client %s using QoS%d\n", STOPIC, CLIENTID, QOS);
	opts.onSuccess = onSubscribe;
	opts.onFailure = onSubscribeFailure;
	opts.context = client;

	deliveredtoken = 0;

	if ((rc = MQTTAsync_subscribe(client, STOPIC, QOS, &opts)) != MQTTASYNC_SUCCESS)
	{
		printf("Failed to start subscribe, return code %d\n", rc);
		exit(EXIT_FAILURE);
	}
}

int main(int argc, char* argv[])
{
	
	
	cJSON *root;
	char *cjson_data = NULL;
	
	
	cssl_start();
        ser=cssl_open(argv[1],NULL,0,115200,8,0,1);
        if (!ser)
                printf("%s\n",cssl_geterrormsg());

	MQTTAsync client;
        MQTTAsync_disconnectOptions disc_opts = MQTTAsync_disconnectOptions_initializer;
	MQTTAsync_connectOptions conn_opts = MQTTAsync_connectOptions_initializer;
	MQTTAsync_message pubmsg = MQTTAsync_message_initializer;
	MQTTAsync_token token;
	int rc;
	MQTTAsync_create(&client, ADDRESS, CLIENTID, MQTTCLIENT_PERSISTENCE_NONE, NULL);
	MQTTAsync_setCallbacks(client, NULL, connlost, msgarrvd, NULL);
	conn_opts.keepAliveInterval = 20;
	conn_opts.cleansession = 1;
	conn_opts.onSuccess = onConnect;
	conn_opts.onFailure = onConnectFailure;
	conn_opts.context = client;
	
	
	
	if ((rc = MQTTAsync_connect(client, &conn_opts)) != MQTTASYNC_SUCCESS)
	{
		printf("Failed to start connect, return code %d\n", rc);
		exit(EXIT_FAILURE);
	}

 	unsigned char recvdat[60]={0};	
	MQTTAsync_responseOptions opts = MQTTAsync_responseOptions_initializer;
	opts.onSuccess = onSend;
	opts.context = client;
	pubmsg.qos = QOS;
	pubmsg.retained = 0;
	deliveredtoken = 0;
	sleep(1);
   	 int n,i;
	char msg[60]={0};
	while((!finished)&&(!subscribed))
	{
		n = cssl_getdata(ser,recvdat,60);
		cssl_drain(ser);
		if(n == -1)
			printf("serial read fail\n");
		else
		{
			for(i=0; i<n; i++)
				printf("%02X ",recvdat[i]);
			printf("\n");
			sprintf(msg,"light:%d %d",recvdat[6]-0,recvdat[7]-0);
			root = cJSON_CreateObject();
			cJSON_AddItemToObject(root, "photosensitive", cJSON_CreateNumber((((recvdat[6]-0) << 8)|recvdat[7]-0)));
			cjson_data = cJSON_Print(root);
			pubmsg.payload = cjson_data;
			pubmsg.payloadlen = strlen(cjson_data);
			if ((rc = MQTTAsync_sendMessage(client, TOPIC, &pubmsg, &opts)) != MQTTASYNC_SUCCESS)
			printf("Failed to start sendMessage, return code %d\n", rc);

		}	
		free(cjson_data);
		cJSON_Delete(root);
	}
	cssl_close(ser);
	if ((rc = MQTTAsync_disconnect(client, &disc_opts)) != MQTTASYNC_SUCCESS)
	{
		printf("Failed to start sendMessage, return code %d\n", rc);
		exit(EXIT_FAILURE);
	}
	MQTTAsync_destroy(&client);
 	return rc;
}
  
