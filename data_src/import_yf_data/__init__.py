# -*- coding:utf-8 -*-

from flask import Blueprint

import_yf_data_api = Blueprint("import_yf_data", __name__)

from import_yf_data import import_yf_data
