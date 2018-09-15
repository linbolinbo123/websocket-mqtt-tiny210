CC=gcc
pub:pubc.c cssl.o cJSON.o
	$(CC) -o pub pubc.c cssl.o cJSON.o -I /usr/include -L /usr/lib -lpaho-mqtt3a
cssl.o:cssl.c cssl.h
	$(CC) -Wall -D_GNU_SOURCE -g -O -c cssl.c
cJSON.o: cJSON.c cJSON.h
	$(CC) -Wall -D_GNU_SOURCE -g -O -c cJSON.c
clean:
	rm -f *.o pub
