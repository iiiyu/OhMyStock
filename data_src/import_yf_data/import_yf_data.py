from import_yf_data import import_yf_data_api
from flask import current_app
from flask import request
from flask_pymongo import PyMongo
from datetime import datetime
import yfinance as yf
import re

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
def init_yf_historical(symbol):
    period = "max"
    interval = "1d"
    if request.args:
        args = request.args
        if "period" in args:
            period = args.get("period")

        if "interval" in args:
            interval = args.get("interval")

    now = datetime.now()
    try:
        mongo = PyMongo(current_app)
        collection_name = symbol + '_historical_collection'
        historical_collection = mongo.db[collection_name]
        historical = get_yf_data(symbol, period, interval)
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

@import_yf_data_api.route("/data/yf/daily/<symbol>")
def update_yf_daily(symbol):
    period = "1y"
    interval = "1d"
    now = datetime.now()
    try:
        mongo = PyMongo(current_app)
        collection_name = symbol + '_historical_collection'
        historical_collection = mongo.db[collection_name]
        historical = get_yf_data(symbol, period, interval)
        data = historical.tail(3).to_dict('index')
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
        'Message': "update yf daily " + symbol
    }


def get_yf_data(symbol, period="max", interval="1d"):
    company = yf.Ticker(symbol)
    historical = company.history(period=period, interval=interval, auto_adjust = True)
    # TODO: Calculator tech index
    maUsed = [5,20,60,120]
    
    for ma in maUsed:
        historical["SMA"+str(ma)]=round(historical["Close"].rolling(window=ma).mean(), 2)
        historical["EMA"+str(ma)]=round(historical["Close"].ewm(span=ma, adjust=False).mean(), 2)

    return historical

        
