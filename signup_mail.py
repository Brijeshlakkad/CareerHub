#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import sys
import os
import re

from smtplib import SMTP_SSL as SMTP 
from email.mime.text import MIMEText
import cgi, cgitb 

form = cgi.FieldStorage() 
print("Content-type:text/html\r\n\r\n")
print("<html>")
print("<head>")
print("<title>Text Area - Fifth CGI Program</title>")
print("</head>")
print("<body>")

if form.getvalue('forget_email'):
	forget_email = form.getvalue('forget_email')
	SMTPserver = 'smtp.gmail.com'
	sender =     'brijeshlakkad22@gmail.com'
	destination = forget_email
	USERNAME = "brijeshlakkad22@gmail.com"
	PASSWORD = "124567267b"
	
	text_subtype = 'html'
	content="""\
	Test message
	"""
	subject="Sent from Python"
	
	try:
		msg = MIMEText(content, text_subtype)
		msg['Subject']= subject
		msg['From']   = sender 
		conn = SMTP(SMTPserver)
		
		conn.set_debuglevel(False)
		conn.login(USERNAME, PASSWORD)
		try:
			conn.sendmail(sender, destination, msg.as_string())
			print("<b>Password successfully sent to %s email</b>"% forget_email)
			print("<a href='forget_password.php?femail=%s'>Click here</a> to resend"% forget_email)
		finally:
			conn.quit()
	except Exception:
		print("<b>Error: unable to send email</b>")
else:
	print("<span style='color:red;'>Please Try Again !</span>")
	
print("</body>")
print ("</html>")