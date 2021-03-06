import requests
from import_data import import_data_api
from flask import current_app
from flask_pymongo import PyMongo
import datetime
import yfinance as yf
import json
import random
import os
# from headers_generator import make_headers


basedir = os.path.abspath(os.path.dirname(__file__))
data_file = os.path.join(basedir, 'user-agents.txt')
# with open(data_file, 'r') as f:
#     USER_AGENTS_LIST = f.read().splitlines()

USER_AGENTS_LIST = [
    'Mozilla/5.0 (Windows; U; Windows NT 6.1; x64; fr; rv:1.9.2.13) Gecko/20101203 Firebird/3.6.13',
    'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko',
    'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201',
    'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
    'Mozilla/5.0 (Windows NT 5.2; RW; rv:7.0a1) Gecko/20091211 SeaMonkey/9.23a1pre'
]

ACCEPT_LANGUAGE = 'en/us'
ACCEPT_ENCODING = "br, gzip, deflate"
ACCEPT = "test/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
REFERER = 'https://google.com'


def make_headers():
    '''generate random user agents'''
    headers = {
        'User-Agent': random.choice(USER_AGENTS_LIST),
        'Accept-Language': ACCEPT_LANGUAGE,
        'Accept-Encoding': ACCEPT_ENCODING,
        'Accept': ACCEPT,
        'Referer': REFERER
    }
    return headers


@import_data_api.route("/data/nasdaq/companies")
def get_companies():
    # Get nadaq all companies list
    # GET https://api.nasdaq.com/api/screener/stocks
    try:
        response = requests.get(
            url="https://api.nasdaq.com/api/screener/stocks",
            params={
                "tableonly": "true",
                "limit": "25",
                "offset": "0",
                "download": "true",
            },
            headers=make_headers(),
        )
        # print('Response HTTP Status Code: {status_code}'.format(
        #     status_code=response.status_code))
        # print('Response HTTP Response Body: {content}'.format(
        #     content=response.content))
        jsonobject = response.json()
        mongo = PyMongo(current_app)
        collection = mongo.db.nasdaq_companies
        for item in jsonobject["data"]["rows"]:
            collection.update({'symbol':item['symbol']}, item, upsert=True)
            # print(item)
            # collection.insert(item)

        # collection.insert_many(jsonobject["data"]["rows"])

    except requests.exceptions.RequestException:
        print('HTTP Request failed')

    return {
        'Code': 0,
        'Message': "Import companies."
    }
