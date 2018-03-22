#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import institute_reload_mess
import institute_reload_history
import security
print("Content-type:text/html\r\n\r\n")

form = cgi.FieldStorage()	
if form.getvalue('hist_reload'):
	c_id1 = security.protect_data(form.getvalue('hist_reload'))
	institute_reload_history.reload_history(c_id1)

if form.getvalue('hist_delete'):
	c_id2 = security.protect_data(form.getvalue('hist_delete'))
	institute_reload_history.delete_history(c_id2)
	
if form.getvalue('delete_all_hist'):
	c_id3 = security.protect_data(form.getvalue('delete_all_hist'))
	institute_reload_history.delete_all_history(c_id3)
	institute_reload_history.reload_history(c_id3)

if form.getvalue('mess_reload'):
	c_id4 = security.protect_data(form.getvalue('mess_reload'))
	institute_reload_mess.reload_messages(c_id4)

if form.getvalue('mess_delete'):
	c_id5 = security.protect_data(form.getvalue('mess_delete'))
	institute_reload_mess.delete_message(c_id5)
	
if form.getvalue('delete_all_mess'):
	c_id6 = security.protect_data(form.getvalue('delete_all_mess'))
	institute_reload_mess.delete_all_mess(c_id6)
	institute_reload_mess.reload_messages(c_id6)

if form.getvalue('hist_total'):
	c_id7 = security.protect_data(form.getvalue('hist_total'))
	institute_reload_history.history_total_count(c_id7)
	
if form.getvalue('mess_total'):
	c_id8 = security.protect_data(form.getvalue('mess_total'))
	institute_reload_mess.mess_total_count(c_id8)

if form.getvalue('certificate_reload'):
	c_id9 = security.protect_data(form.getvalue('certificate_reload'))
	institute_reload_certificate.reload_certificate(c_id9)
	
if form.getvalue('certificate_total'):
	c_id10 = security.protect_data(form.getvalue('certificate_total'))
	institute_reload_certificate.certificate_total_count(c_id10)