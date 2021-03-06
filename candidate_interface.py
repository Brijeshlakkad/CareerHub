#!/usr/bin/python
import cgi, cgitb
import sys
import os
import pymysql
import candidate_reload_mess
import candidate_reload_history
import candidate_reload_certificate
import accept_offer
import security
import update_filter_certificate
import test_running
import add_profile_visit
import predictor_cal
print("Content-type:text/html;Content-type: image/jpeg\r\n\r\n")
cgitb.enable(display=0, logdir="/path/to/logdir")

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

if form.getvalue('mess_reload') and form.getvalue('load_inbox'):
	load_inbox = security.protect_data(form.getvalue('load_inbox'))
	c_id4 = security.protect_data(form.getvalue('mess_reload'))
	candidate_reload_mess.reload_messages(load_inbox,c_id4)

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

if form.getvalue('load_inbox') and form.getvalue('mess_total'):
	load_inbox = security.protect_data(form.getvalue('load_inbox'))
	cand_id = security.protect_data(form.getvalue('mess_total'))
	candidate_reload_mess.mess_count_part(load_inbox,cand_id)

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

if form.getvalue('deny_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid = security.protect_data(form.getvalue('deny_offer'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	role="Denied_offer"
	accept_offer.deny_offer(candid,instid,jobid,role)

if form.getvalue('check_offer') and form.getvalue('inst_id') and form.getvalue('job_id'):
	candid= security.protect_data(form.getvalue('check_offer'))
	instid = security.protect_data(form.getvalue('inst_id'))
	jobid = security.protect_data(form.getvalue('job_id'))
	status=accept_offer.check_offer_cand(candid,instid,jobid)
	print("%s"%status)

if form.getvalue('skills[]') and form.getvalue('cand_id'):
	skills_arr = form.getvalue('skills[]')
	candid = security.protect_data(form.getvalue('cand_id'))
	update_filter_certificate.update_filter_panel(skills_arr,candid)

if form.getvalue('visited_tests'):
	candid = security.protect_data(form.getvalue('visited_tests'))
	update_filter_certificate.update_filter_visited(candid)

if form.getvalue('que_reload') and form.getvalue('current_id'):
	testid = security.protect_data(form.getvalue('que_reload'))
	current_id = security.protect_data(form.getvalue('current_id'))
	test_running.que_reload(testid,current_id)

if form.getvalue('delete_visited_test'):
	running_testid = security.protect_data(form.getvalue('delete_visited_test'))
	test_running.delete_visited_test(running_testid)

if form.getvalue('visitor_id') and form.getvalue('profile_id'):
	visitor_id = security.protect_data(form.getvalue('visitor_id'))
	profile_id = security.protect_data(form.getvalue('profile_id'))
	add_profile_visit.add_visitor(visitor_id,profile_id)

if form.getvalue('predictor_id') and form.getvalue('job_id'):
	cand_id = security.protect_data(form.getvalue('predictor_id'))
	job_id = security.protect_data(form.getvalue('job_id'))
	predictor_cal.predictor_cal(cand_id,job_id)
