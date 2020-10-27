# OhMyStock

自建给室友用的简单 Screener 平台

## 起因

雷公在Slack上提出了要做自己平台的项目想法。

我老婆特别兴奋的想要参与。无奈我的水平有限。就自己写了给老婆自己玩好了。

所以这是一个菜鸟般实现。

## 雷公的原始需求

1. 统计方法显示（秒级）
2. 用户权限管理

## 本项目实现功能

1. 统计方法显示 （天级）
2. 用户权限管理

## Demo

[Demo 地址](https://stock.ohmyapps.com/admin)

![image.png](https://i.loli.net/2020/10/25/SBYxgePKRQcAH5j.png)

![image.png](https://i.loli.net/2020/10/25/oJIrW1TBwzgAsDd.png)

欢迎拍砖

## 分析未来项目难点

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


## 寻找免费数据源
这个项目目前最难的地方就免费数据源的寻找。 Google出来其实挺多 API 提供商但是都贵。
本着节约就是美德的精神继续思考解决方案。

1. alphavantage API 可以每天免费调用500次，其中有 API 可以拿到某个股票的历史所有数据。
2. iexcloud API 一个月可以免费调用50000次的最近5天历史数据。如果付费，则可以拿到历史数据。

所以结合起来感觉就可以做到天级的数据更新。

然后是找标普500的公司数据，找了好久好久。第一个版本在 github 上找了个list。结果导入进去好多公司已经退市。 后面发现就算wiki上的也不是最新的。然后去标普公司的官网上找也没有。
最后在老婆的提示下发现 TradingView 上有。 然后浏览器右键了一下 TradingView 看到 API 巨靠谱。 但是发现 TradingView 的官方 API 需要 Broker 的资格。 忍住了全部从 TradingView 爬数据，因为用屁股想了5秒肯定有反爬机制。所以最后只是用它来进行公司数据的初始化。

### 免费数据源平台注册一下吧

[注册TradingView](https://www.tradingview.com/gopro/?share_your_love=iiiyu)

[注册iexcloud](https://iexcloud.io/s/8ec8e635)

[注册ALPHA VANTAGE](https://www.alphavantage.co/support/#api-key)

## 项目计划

[Project Plan](https://github.com/iiiyu/OhMyStock/projects/1)

## 项目部署顺序

搭建以后需要按顺序导入这些数据

``` shell
php artisan admin:install
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=MenuSeeder
php artisan db:seed --class=CompanySeeder

// 导入 s&p500 公司数据
php artisan stock:tradingview:spx

// 用 alpha 导入历史数据
php artisan stock:alpha:historical:all

// 用 iex 来进行日数据更新
php artisan stock:iex:historical:all

// 后台运行
php artisan stock:alpha:historical:all > ~/ohmystock.out.file 2>&1 &
```

Smile every day.
