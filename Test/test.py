import pymysql.cursors
import requests
import json
import time
import os
import random

cookie = None
os.environ['NO_PROXY'] = '127.0.0.1'
IP = '127.0.0.1:5001'
fObj = open('config.json',)
data = json.load(fObj)

dataMaster = {
  "userName" : data['userNameMaster'],
  "passWord" : data['passwordMaster']
}

def insertPeople():
  user = {
    "username" : "test1234",
    "fullname" : "test1234",
    "password" : "test1234",
    "date_salary" : "2022-05-10"
  }
  response = requests.post(f"http://{IP}/API/Controllers/UsersController.php",
                            data=user)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  user = {
    "username" : "test123",
    "fullname" : "test123",
    "password" : "test123",
  }
  response = requests.post(f"http://{IP}/API/Controllers/UsersController.php",
                            data=user)
  formularObject = json.loads(response.text)
  assert "Error" in formularObject
  print("Test insertPeople passed!")

def insertPusculite():
  pusculita = {
    "denumire" : "economii",
    "procentaj" : "10",
    "status" : "activ",
    "id_user" : "1"
  }
  response = requests.post(f"http://{IP}/API/Controllers/PusculiteController.php",
                            data=pusculita)
  print(response.text)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  pusculita = {
    "denumire" : "donatii",
    "procentaj" : "10",
    "status" : "activ",
    "id_user" : "1"
  }
  response = requests.post(f"http://{IP}/API/Controllers/PusculiteController.php",
                            data=pusculita)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  pusculita = {
    "denumire" : "investitii",
    "procentaj" : "10",
    "status" : "activ",
    "id_user" : "1"
  }
  response = requests.post(f"http://{IP}/API/Controllers/PusculiteController.php",
                            data=pusculita)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  pusculita = {
    "denumire" : "distractie",
    "procentaj" : "5",
    "status" : "activ",
    "id_user" : "1"
  }
  response = requests.post(f"http://{IP}/API/Controllers/PusculiteController.php",
                            data=pusculita)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  pusculita = {
    "denumire" : "necesitati",
    "procentaj" : "45",
    "status" : "activ",
    "id_user" : "1"
  }
  response = requests.post(f"http://{IP}/API/Controllers/PusculiteController.php",
                            data=pusculita)
  formularObject = json.loads(response.text)
  assert "Error" not in formularObject
  print("Test insertPusculite passed!")

# def testDataInSolicitari():
#   tickets = {
#     "cod" : "94375853,feirhterhter,43y5y34hfdyf84,hrf8e63r443",
#     "prioritate" : "0",
#     "intern" : "on"
#   }
#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?solicitare=true",
#                             headers={"Cookie": cookie}, data=tickets)
#   formularObject = json.loads(response.text)
#   assert "Error" not in formularObject or print(formularObject)
#   response = requests.get(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?activi=true&page=1",
#                             headers={"Cookie": cookie}, data=tickets)
#   group = json.loads(response.text)
#   assert "Error" not in group or print(group)
#   response = requests.delete(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?id={group['records'][0]['id']}",
#                             headers={"Cookie": cookie})
#   formularObject = json.loads(response.text)
#   assert "Error" not in formularObject
#   tickets = {
#     "cod" : "94375853",
#     "prioritate" : "",
#     "intern" : "on"
#   }
#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?solicitare=true",
#                             headers={"Cookie": cookie}, data=tickets)
#   formularObject = json.loads(response.text)
#   assert "Error" in formularObject or print(group)
#   print("Test testDataInSolicitari passed!")

# def testDataInSolicitareHistory():
#   tickets = {
#     "cod" : "94375853,feirhterhter,43y5y34hfdyf84,hrf8e63r443",
#     "prioritate" : "0"
#   }
#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?solicitare=true",
#                             headers={"Cookie": cookie}, data=tickets)
#   group = json.loads(response.text)
#   assert "Error" not in group or print(group)
#   response = requests.get(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?activi=true&page=1",
#                             headers={"Cookie": cookie}, data=tickets)
#   group = json.loads(response.text)
#   assert "Error" not in group or print(group)
#   tickets = {
#     "id" : group['records'][0]['id'],
#     "payload": {
#       "94375853": {
#         "stoc_sistemic": 1294,
#         "stoc_fizic": 15,
#         "comment": "ana are mere"   
#       },
#       "feirhterhter": {
#         "stoc_sistemic": 15,
#         "stoc_fizic": 145,
#         "comment": "adsafa"   
#       },
#       "43y5y34hfdyf84": {
#         "stoc_sistemic": 654,
#         "stoc_fizic": 1,
#         "comment": "hdhdjj"   
#       },
#       "hrf8e63r443": {
#         "stoc_sistemic": 1294,
#         "stoc_fizic": 132,
#         "comment": "hdhdjjg"   
#       }
#     }
#   }
#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/CoduriController.php?patch=true",
#                             headers={"Cookie": cookie}, data=json.dumps(tickets))
#   formularObject = json.loads(response.text)
#   assert "Error" not in formularObject
#   tickets = {
#     "id" : group['records'][0]['id'],
#     "payload": {
#       "94375853": {
#         "stoc_sistemic": "",
#         "stoc_fizic": 15,
#         "comment": "ana are mere"   
#       },
#       "feirhterhter": {
#         "stoc_sistemic": 15,
#         "stoc_fizic": 145,
#         "comment": "adsafa"   
#       },
#       "43y5y34hfdyf84": {
#         "stoc_sistemic": 654,
#         "stoc_fizic": 1,
#         "comment": "hdhdjj"   
#       },
#       "hrf8e63r443": {
#         "stoc_sistemic": 1294,
#         "stoc_fizic": 132,
#         "comment": "hdhdjjg"   
#       }
#     }
#   }

#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/CoduriController.php?patch=true",
#                             headers={"Cookie": cookie}, data=json.dumps(tickets))
#   formularObject = json.loads(response.text)
#   assert "Error" in formularObject
#   print("Test testDataInSolicitareHistory passed!")

# def testForDeleteSolicitare():
#   tickets = {
#     "cod" : "645644,5456456,64765766,54353543",
#     "prioritate" : "1"
#   }
#   response = requests.post(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?solicitare=true",
#                             headers={"Cookie": cookie}, data=tickets)
#   group = json.loads(response.text)
#   assert "Error" not in group or print(group)
#   response = requests.get(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?activi=true&page=1",
#                             headers={"Cookie": cookie}, data=tickets)
#   group = json.loads(response.text)
#   assert "Error" not in group or print(group)
#   response = requests.delete(f"http://{IP}/Logistica/InventarBeta/API/Controllers/SolicitariController.php?id={group['records'][0]['id']}",
#                             headers={"Cookie": cookie})
#   formularObject = json.loads(response.text)
#   assert "Error" not in formularObject
#   print("Test testForDeleteSolicitare passed!")

def testAll():
  import budgetDb
  insertPeople()
  insertPusculite()
  print("Tests passed!")

testAll()