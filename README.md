# JumpJumpHelper
用~~最好的语言~~ PHP 玩微信跳一跳

## 更新

 - 2018.01.05
  - 固定延迟改随机延迟，可设范围
  - 增加随机点按下和稍微挪动抬起，模拟手指
  - 2.5D距离修正，修正这种情况：[如图](http://ww2.sinaimg.cn/large/0060lm7Tly1fn5159h6x2j30fm0rrwga.jpg)
 - 2018.01.01
  - 修复屏幕分辨率兼容性
  - 采用 Mathematica 拟合函数
 - 2017.12.31
  - 新的中间点匹配函数
  - 基于二次函数拟合计算按压时间

## 依赖

 - php-cli (>=5.6)
 - php-gd
 - adb 调试工具
 - android 手机

## 食用方式

 1. 手机进入设置 > 开发者选项，打开 USB 调试、模拟触控
 2. 手机连接电脑，安装 adb 相关驱动，检查 `adb devices` 命令是否能显示设备 ID
 3. 微信进入跳一跳游戏，点击开始
 4. 电脑运行 `php run.php`

如果发现跳跃过远/近，可以适当调节 `config.php` 中的参数

## 效果图

![效果图](https://i.loli.net/2017/12/31/5a488c9429845.png)

![效果图](https://i.loli.net/2018/01/01/5a4a3ab294a7b.png)


## 脚本原理

 1. 截取手机屏幕，并传到电脑上。
 2. 通过分析图片，取得当前任务及其目标位置
 3. 计算按压时间，通过 adb 命令模拟点按操作

## 识别原理

 - 人物位置：通过颜色匹配人物底座第一个单峰位置
 - 目标位置：排除背景色后，从上至下找到第一个单峰位置，对于未找到的情况采用角度矫正（所有识别数据储存在 screen 文件夹中）

## 拟合函数

![mathematica](https://i.loli.net/2018/01/01/5a4a3b643dc30.png)

## 参考资料

|项目|作者|
|---|---|
|[教你用Python来玩微信跳一跳](https://github.com/wangshub/wechat_jump_game)|[@wangshub](https://github.com/wangshub)|
|[微信跳一跳自动玩耍工具](https://github.com/aOrz/wx_jump_game)|[@aOrz](https://github.com/aOrz)|
