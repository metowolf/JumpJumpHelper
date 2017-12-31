# JumpJumpHelper
用~~最好的语言~~ PHP 玩微信跳一跳

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


## 脚本原理

 1. 截取手机屏幕，并传到电脑上。
 2. 通过分析图片，取得当前任务及其目标位置
 3. 计算按压时间，通过 adb 命令模拟点按操作

## 识别原理

 - 人物位置：通过训练数据匹配人物底座最宽的部分
 - 目标位置：排除背景色后，从上至下找到第一个单峰位置，但遇到一些特殊情况会失败，待完善（所有识别数据储存在 screen 文件夹中）


## 参考资料

|项目|作者|
|---|---|
|[教你用Python来玩微信跳一跳](https://github.com/wangshub/wechat_jump_game)|[@wangshub](https://github.com/wangshub)|
|[微信跳一跳自动玩耍工具](https://github.com/aOrz/wx_jump_game)|[@aOrz](https://github.com/aOrz)|
