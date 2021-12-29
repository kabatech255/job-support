import boto3
import json
from boto3.dynamodb.conditions import Key

def lambda_handler(event, context):
  print(json.dumps(event))
  res = event['prev']['result']
  return res