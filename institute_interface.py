#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
import os
import MySQLdb
import institute_reload_mess
import institute_reload_history
import inst_get_cand_certificates
import security
import send_offer
import institute_reload_visits
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

if form.getvalue('mess_reload') and form.getvalue('load_inbox'):
	load_inbox = security.protect_data(form.getvalue('load_inbox'))
	c_id4 = security.protect_data(form.getvalue('mess_reload'))
	institute_reload_mess.reload_messages(load_inbox,c_id4)

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
	
if form.getvalue('load_inbox') and form.getvalue('mess_total'):
	load_inbox = security.protect_data(form.getvalue('load_inbox'))
	cand_id = security.protect_data(form.getvalue('mess_total'))
	institute_reload_mess.mess_count_part(load_inbox,cand_id)
	
if form.getvalue('get_cand_certificates'):
	cand_id = security.protect_data(form.getvalue('get_cand_certificates'))
	inst_get_cand_certificates.reload_cand_certificates(cand_id)

if form.getvalue('send_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('send_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	role="Offer"
	send_offer.send_offer_cand(c_id,inst_id,j_id,role)
	
if form.getvalue('delete_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('delete_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	role="Offer"
	send_offer.delete_offer_cand(c_id,inst_id,j_id,role)
	
if form.getvalue('check_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	c_id = security.protect_data(form.getvalue('check_offer'))
	inst_id=security.protect_data(form.getvalue('inst_id'))
	j_id=security.protect_data(form.getvalue('job_id'))
	status=send_offer.check_offer_cand(c_id,inst_id,j_id)
	status=security.protect_data(status)
	print("%s"%status)
	
if form.getvalue('visits_reload'):
	inst_id = security.protect_data(form.getvalue('visits_reload'))
	institute_reload_visits.reload_visits(inst_id)

if form.getvalue('visit_delete'):
	inst_id = security.protect_data(form.getvalue('visit_delete'))
	institute_reload_visits.delete_visit(inst_id)
	
if form.getvalue('delete_all_visits'):
	inst_id = security.protect_data(form.getvalue('delete_all_visits'))
	institute_reload_visits.delete_all_visits(inst_id)

if form.getvalue('visits_total'):
	inst_id = security.protect_data(form.getvalue('visits_total'))
	institute_reload_visits.visits_total_count(inst_id)
	
if form.getvalue('total_impressions'):
	inst_id = security.protect_data(form.getvalue('total_impressions'))
	institute_reload_visits.impressions_total_count(inst_id)