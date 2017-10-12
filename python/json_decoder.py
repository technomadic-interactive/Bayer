import os, sys
import re
import json
import fileinput
import datetime
import binascii
"""
class LoRa:
	def __init__(self,cmd,eui,ts,fcnt,port,ack,data):
		self.cmd = cmd
		self.eui = eui
		self.ts = ts
		self.fcnt = fcnt
		self.port = port
		self.ack = ack
		self.data = data
		def __repr__(self):
        		return 'Pair({0.x!r}, {0.y!r})'.format(self)
		def __str__(self):
        		return '({0.x!s}, {0.y!s})'.format(self)
"""
class PayLoad(object):
	def __init__(self,j):
		self.__dict__=json.loads(j)


regex = re.compile("rx")
for line in fileinput.input():
  result = regex.search(line)
  if result:
	try:
#--- print decoded JSON ---
		p=PayLoad(line)
		s= p.ts / 1000.0
		print(p.EUI,datetime.datetime.fromtimestamp(s).strftime('%Y-%m-%d %H:%M:%S.%f'),binascii.a2b_hex(p.data))
#		print binascii.a2b_hex(p.data)
#		print(p.EUI,p.ts,p.data)
#		p=PayLoad(data)
#		print(p.eui,p.ts,p.dat))
#		print( data["EUI"], data["ts"], data["data"])
#		print(data.eui)
#		print json.dumps(data)
	except ValueError:
		pass  
  else:
	pass
