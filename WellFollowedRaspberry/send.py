#!/usr/bin/env python
import datetime
import pika, random, threading, math

credentials = pika.PlainCredentials('wellfollowed', 'wellfollowed')
parameters = pika.ConnectionParameters('localhost',
                                       5672,
                                       '/',
                                       credentials)
connection = pika.BlockingConnection(parameters)
channel = connection.channel()
channel.queue_declare(queue='well_followed_sensor', durable=True)

def test() :
    val = str(math.ceil(random.uniform(14, 20)))
    now = datetime.datetime.now().strftime('%Y-%m-%dT%H:%M:%S%z')
    body = '{"sensorName":"sensor1","type":"numeric","value": ' + val + ',"date": "' + now + '+0000"}'
    channel.basic_publish(exchange='',
                      routing_key='well_followed_sensor',
                      body=body)
    print(now + ' : ' + body)
    threading.Timer(1, test).start()

test()