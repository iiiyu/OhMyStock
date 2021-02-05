FROM python:latest

RUN pip install --upgrade pip \
    && pip install lxml bs4 pandas tushare

RUN mkdir /src
WORKDIR /src

ENTRYPOINT [ "python" ]
