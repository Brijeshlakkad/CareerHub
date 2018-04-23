conn,cursor=config.connect_to_database()
obj=candidate()
obj.candidate_details(conn,cursor,"76")
print("%s"%obj.cand_rank)