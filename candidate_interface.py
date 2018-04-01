#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import candidate_reload_mess
import candidate_reload_history
import candidate_reload_certificate
import accept_offer
import security
print("Content-type:text/html;Content-type: image/jpeg\r\n\r\n")

form = cgi.FieldStorage()	
if form.getvalue('hist_reload'):
	c_id1 = security.protect_data(form.getvalue('hist_reload'))
	candidate_reload_history.reload_history(c_id1)

if form.getvalue('hist_delete'):
	c_id2 = security.protect_data(form.getvalue('hist_delete'))
	candidate_reload_history.delete_history(c_id2)
	
if form.getvalue('delete_all_hist'):
	c_id3 = security.protect_data(form.getvalue('delete_all_hist'))
	candidate_reload_history.delete_all_history(c_id3)
	candidate_reload_history.reload_history(c_id3)

if form.getvalue('mess_reload'):
	c_id4 = security.protect_data(form.getvalue('mess_reload'))
	candidate_reload_mess.reload_messages(c_id4)

if form.getvalue('mess_delete'):
	c_id5 = security.protect_data(form.getvalue('mess_delete'))
	candidate_reload_mess.delete_message(c_id5)
	
if form.getvalue('delete_all_mess'):
	c_id6 = security.protect_data(form.getvalue('delete_all_mess'))
	candidate_reload_mess.delete_all_mess(c_id6)
	candidate_reload_mess.reload_messages(c_id6)

if form.getvalue('hist_total'):
	c_id7 = security.protect_data(form.getvalue('hist_total'))
	candidate_reload_history.history_total_count(c_id7)
	
if form.getvalue('mess_total'):
	c_id8 = security.protect_data(form.getvalue('mess_total'))
	candidate_reload_mess.mess_total_count(c_id8)

if form.getvalue('certificate_reload'):
	c_id9 = security.protect_data(form.getvalue('certificate_reload'))
	candidate_reload_certificate.reload_certificate(c_id9)
	
if form.getvalue('certificate_total'):
	c_id10 = security.protect_data(form.getvalue('certificate_total'))
	candidate_reload_certificate.certificate_total_count(c_id10)
	
if form.getvalue('cand_id') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid = security.protect_data(form.getvalue('cand_id'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	role="Accepted"
	accept_offer.accept_offer(candid,instid,jobid,role)

if form.getvalue('check_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid= security.protect_data(form.getvalue('check_offer'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	status=accept_offer.check_offer_cand(candid,instid,jobid)
	print("%s"%status)