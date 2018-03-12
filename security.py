#!C:\Users\RAJ\AppData\Local\Programs\Python\Python36\python
import cgi, cgitb 
import sys
def protect_data(xyz):
	xyz=cgi.escape(xyz)
	xyz=xyz.strip()
	return xyz