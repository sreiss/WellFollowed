#!/usr/bin/env python
import pika, random, threading, math

credentials = pika.PlainCredentials('wellfollowed', 'wellfollowed')
parameters = pika.ConnectionParameters('vm-27.iutrs.unistra.fr',
                                       5672,
                                       '/',
                                       credentials)
connection = pika.BlockingConnection(parameters)
channel = connection.channel()
channel.queue_declare(queue='well_followed_sensor', durable=True)

def test() :
    val = str(math.ceil(random.uniform(14, 20)))
    channel.basic_publish(exchange='',
                      routing_key='well_followed_sensor',
                      body='{"name":"sensor2","value": ' + val + ',"date":"2015-12-29T02:00:00+0000"}')
    print(" [" + val + "] Sent 'Hello World!'")
    threading.Timer(1, test).start()

test()