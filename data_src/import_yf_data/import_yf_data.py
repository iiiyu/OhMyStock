import requests
from import_yf_data import import_yf_data_api
from flask import current_app
from flask_pymongo import PyMongo
import datetime
import yfinance as yf


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
    yf_companies_collection = mongo.db.yf_companies

    for item in result:
        if(item['symbol'].find("^") == -1):
            symbol = item['symbol'].replace("/", "-")
            try:
                company = yf.Ticker(symbol)
                company_info = company.info
                yf_companies_collection.update({'symbol':company_info['symbol']}, company_info, upsert=True)
            except Exception as e:
                pass
            continue


    return {
        'Code': 0,
        'Message': "update-companies"
    }


# Install the Python Requests library:
# `pip install requests`

@import_yf_data_api.route("/test-request")
def send_request():
    # Get nadaq all companies list
    # GET https://api.nasdaq.com/api/screener/stocks

    # try:
    #     response = requests.get(
    #         url="https://api.nasdaq.com/api/screener/stocks",
    #         params={
    #             "tableonly": "true",
    #             "limit": "25",
    #             "offset": "0",
    #             "download": "true",
    #         },
    #         headers={
    #             "Authority": "api.nasdaq.com",
    #             "Accept": "application/json, text/plain, */*",
    #             "Origin": "https://www.nasdaq.com",
    #             "Sec-Fetch-Site": "same-site",
    #             "Sec-Fetch-Mode": "cors",
    #             "Sec-Fetch-Dest": "empty",
    #             "Referer": "https://www.nasdaq.com/",
    #             "Accept-Language": "en-US,en;q=0.9,zh-CN;q=0.8,zh;q=0.7",
    #             "Accept-Encoding": "gzip",
    #         },
    #     )
    #     print('Response HTTP Status Code: {status_code}'.format(
    #         status_code=response.status_code))
    #     print('Response HTTP Response Body: {content}'.format(
    #         content=response.content))
    # except requests.exceptions.RequestException:
    #     print('HTTP Request failed')

    return {
        'Code': 0,
        'Message': "update-companies"
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
