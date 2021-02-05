import tushare as ts

ts.set_token('3953089bcfb103fe4941da23010737798ce57ede0a022de69ec2971c')

pro = ts.pro_api()

# df = pro.query('trade_cal', exchange='', start_date='20180901', end_date='20181001', fields='exchange,cal_date,is_open,pretrade_date', is_open='0')

# df = pro.us_basic()
df = pro.us_daily(ts_code='AAPL', trade_date='20210122', fields='ts_code,trade_date,close,open,high,low,pre_close,change,pct_change,vol,amount,vwap,turnover_ratio,total_mv,pe,pb')


print(df)
