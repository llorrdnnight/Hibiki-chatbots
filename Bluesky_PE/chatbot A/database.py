import mysql.connector 
import string
import random

def connect(): 
  conn = mysql.connector.connect(
  host='10.128.63.132',
  database='chatbot',
  user='test',
  password='1Azerty?!')
  # conn = mysql.connector.connect(
  # host='localhost',
  # database='chatbot',
  # user='webuser',
  # password='Lab2020')
  return conn


def New_room(room):
  conn = connect()
  cursor = conn.cursor()
  query = "SELECT Room_ID FROM chatrooms WHERE Room_ID = %s"
  cursor.execute(query,(room,))
  if len(cursor.fetchall()) <= 0:
    query =  ("INSERT INTO chatrooms(Room_ID)" \
    "VALUES (%s)")
    cursor.execute(query, (room,))
    conn.commit()
  cursor.close()
  conn.close()
  
def insert_chat(room, Customer_Employee, text):
  conn = connect()
  cursor = conn.cursor()
  #puts data in database 
  query =  ("INSERT INTO chats( Room_ID, Customer_Employee, Text)" \
  "VALUES (%s,%s,%s)")
  cursor.execute(query, (room, Customer_Employee, text,))
  conn.commit()
  cursor.close()
  conn.close()

def AI_check(room):
  conn = connect()
  cursor = conn.cursor()
  query = "SELECT AI_ON_OFF FROM chatrooms WHERE Room_ID = %s"
  cursor.execute(query,(room,))
  data = cursor.fetchone()
  print(data[0])
  if data[0] == "ON":
    return True
  else:
    return False
  conn.commit()
  cursor.close()
  conn.close()
  
