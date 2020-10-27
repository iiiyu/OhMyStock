# OhMyStock

雷公的项目想法菜鸟般实现。

雷公在群里号召，老婆想要参与。无奈水平有限。就自己写了给老婆自己玩好了。

## 原始需求

1. 统计方法显示（秒级）
2. 用户权限管理

## 实现功能

1. 统计方法显示 （天级）
2. 用户权限管理


![image.png](https://i.loli.net/2020/10/25/SBYxgePKRQcAH5j.png)

![image.png](https://i.loli.net/2020/10/25/oJIrW1TBwzgAsDd.png)

## Demo

[Demo 地址](https://stock.ohmyapps.com/admin)

有兴趣的随便看看


## 未来项目难点

### 原始数据来源
找了一圈，全部都要钱。最后用了免费的 alphavantage.co，但是它也有[限制](https://www.alphavantage.co/premium/)。

然后，哪怕是付费的API，目前看到最小的更新间隔是1分钟。 而且是USD$499左右一个月。目前没看到有API能实现秒级数据。

### 如何秒级数据的同步
目前看起来如何秒级数据的同步这个问题，是整个项目的最难点。
该难点我认为还可以分为两个部分，而且是两个部分都很难：
1. 哪里找有秒级数据源
2. 如何同步秒级数据源并且实时计算

之前在深圳的时候做过一点点新三版相关的。 当时也想要秒级数据。 然后找过方案。 提供API的厂家要不就很贵，要不就也一般。 最后找到了交易所，然后咨询到了交易所的方案是：找到指定供应商，买一个大锅盖来接受交易所的原始文件。延迟比几乎所有的API要好。而且价格也是最低（有资质的情况下） 但是大锅盖的安装和维护是要自己搞定，综合考虑后最后没买大锅盖。

不知美股的交易所原始方案是什么。是不是也是大锅盖的方案。233.

## TODO

- [x] 基本搜索
- [ ] 替换标普500的数据（目前数据随便找的，不准）
- [ ] 基础数据能增量添加（目前只做了历史数据初始化）
- [ ] 基本Cache
- [ ] 基本队列
- [ ] 定时任务
- [ ] 接入新数据源
- [ ] 下一步产品设计

...


## Run Seeder

搭建以后需要按顺序导入这些数据

``` shell
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=MenuSeeder

php artisan db:seed --class=CompanySeeder
```

Smile every day.

[注册TradingView](https://www.tradingview.com/gopro/?share_your_love=iiiyu)

[注册iexcloud](https://iexcloud.io/s/8ec8e635)
