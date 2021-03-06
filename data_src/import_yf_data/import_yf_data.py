import requests
from import_yf_data import import_yf_data_api
from flask import current_app
from flask_pymongo import PyMongo
from datetime import datetime
import yfinance as yf
import re

@import_yf_data_api.route("/test")
def test():
    msft = yf.Ticker("AACQU")
    print(msft.info)

    return {
        'Code': 0,
        'Message': "test"
    }


@import_yf_data_api.route("/data/yf/companies")
def update_yf_companies():
    # search nsdaq company data 
    mongo = PyMongo(current_app)
    nasdaq_companies_collection = mongo.db.nasdaq_companies
    result = nasdaq_companies_collection.find({}, {'symbol': 1})
    i = 0
    for item in result:
        i = i + 1
        if(item['symbol'].find("^") == -1):
            symbol = item['symbol'].replace("/", "-")
            update_yf_company(symbol)
        
        if (i == 5):
            break

    return {
        'Code': 0,
        'Message': "update-companies"
    }

@import_yf_data_api.route("/data/yf/company/<symbol>")
def update_yf_company(symbol):
    now = datetime.now()
    try:
        mongo = PyMongo(current_app)
        yf_companies_collection = mongo.db.yf_companies
        company = yf.Ticker(symbol)
        company_info = company.info
        company_info['updated_at'] = now
        yf_companies_collection.update({'symbol':company_info['symbol']}, company_info, upsert=True)
    except Exception as e:
        return {
            'Code': 1001,
            'Message': 'YF Fetch Data faile',
            'Error' :  str(e)
        }

    return {
        'Code': 0,
        'Message': "update yf company " + symbol
    }



@import_yf_data_api.route("/data/yf/historical/<symbol>")
def update_yf_historical(symbol):
    now = datetime.now()
    try:
        mongo = PyMongo(current_app)
        collection_name = symbol + '_historical_collection'
        historical_collection = mongo.db[collection_name]
        company = yf.Ticker(symbol)
        historical = company.history(period="max",prepost=True)
        data = historical.to_dict('index')
        for key in data:
            new_item = data[key]
            new_item['date'] = datetime.combine(key.date(), datetime.min.time())
            new_item['updated_at'] = now
            historical_collection.update({'date':new_item['date']}, new_item, upsert=True)
    except Exception as e:
        return {
            'Code': 1001,
            'Message': 'YF Fetch Data faile',
            'Error' :  str(e)
        }
    return {
        'Code': 0,
        'Message': "update yf historical " + symbol
    }


@import_yf_data_api.route("/test-mongodb")
def testMongodb():
    mongo = PyMongo(current_app)
    collection = mongo.db.test1_collection
    new_posts = [{"author": "Mike",
                  "text": "Another post!",
                  "tags": ["bulk", "insert"],
                  "date": datetime.datetime(2009, 11, 12, 11, 14)},
                 {"author": "Eliot",
                  "title": "MongoDB is fun",
                  "text": "and pretty easy too!",
                  "date": datetime.datetime(2009, 11, 10, 10, 45)}]

    collection.insert(new_posts)
    return {
        'Code': 0,
        'Message': "test"
    }
