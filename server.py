import pika


creds= pika.PlainCredentials('guest', 'guest')
connection = pika.BlockingConnection(pika.ConnectionParameters('localhost', 5672,'AMERICA', creds))

channel = connection.channel()

channel.queue_declare(queue='test')
def backEndThing(n):
	# Back-end stuff will happen here
	# Most likely will be a switch case to do other things.
	return n;
def on_request(ch, method, props, body):
	# Data will be sent here
	# will most likely be a dict
	#n will equal to the decoded json message then send the queue from there
	#Uhh, how will i define the switch case?
	#n = json_decode thing(body)
	n = 'Goodbye!'
	print "Response from client: " + body
	response = str(n)
	ch.basic_publish(exchange='testExchange', 
			routing_key='test.response', 
			properties=pika.BasicProperties(correlation_id=
							props.correlation_id),
			body=response)

	ch.basic_ack(delivery_tag = method.delivery_tag)
	print "I got the thing!"
channel.basic_qos(prefetch_count=1)
channel.basic_consume(on_request, queue='test')
# Data will listen/receive things here

print " [x] Awaiting RPC requests"

channel.start_consuming()
