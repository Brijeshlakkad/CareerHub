#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import threading
import admin_varify_inst
import MySQLdb
import admin_send_mess_inst
print("Content-type:text/html\r\n\r\n")
status=""
def replay(re):
	global status
	status=re
	
class myThread (threading.Thread):
	def __init__(self, threadID, name, c_id, flag):
		threading.Thread.__init__(self)
		self.threadID = threadID
		self.name = name
		self.c_id = c_id
		self.flag = flag
	def run(self):
		if self.name=="Handle":
			status1=admin_varify_inst.update_database(self.c_id,self.flag);
			replay(status1)
		elif self.name=="Write_to_chat" and status=="11":
			fromuser="Admin"
			if self.flag==1:
				message="verified"
			elif self.flag==0:
				message="rejected"
			status1=admin_send_mess_inst.send_message(self.c_id,fromuser,message);


form = cgi.FieldStorage()	
if form.getvalue('id'):
	c_id1 = (int)(form.getvalue('id'))
if form.getvalue('flag'):
	flag1 = (int)(form.getvalue('flag'))

thread1 = myThread(1, "Handle", c_id1, flag1)
thread2 = myThread(2, "Write_to_chat", c_id1, flag1)

thread1.start()
thread1.join()
thread2.start()
thread2.join()
print(status)