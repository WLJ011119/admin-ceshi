ThinkAdmin v1.0
===============

基于ThinkPHP5.1 感谢ThinkPHP官方的努力祝ThinkPHP越来越好,感谢LayUI让写html变得更加简单
本框架为轻量级后台管理系统,只提供最基础功能,更多功能需根据实际业务由个人进一步开发
核心功能:

 + 后台菜单管理
 + Auth权限检查

需要注意的两个基类:

 + Adminbase 严格的权限检查
 + NotAuth 需要登陆但是不需要权限检查
 
实际开发中有许多应用场景需要权限检查,也有特殊的场景只登陆不要做权限检查,这两个基类可以满足需要
 
> ThinkPHP5的运行环境要求PHP5.6以上。

## 注意事项

手动导入thinkadmin.sql。  
config/database.php 需手动下载,可在[官方仓库](https://github.com/top-think/think.git "")寻找。  
本地没有composer的可以用项目自带的但是要修改composer.bat中php.ini的路径为你本地的路径,更要注意composer不能在开启debug的模式下使用,所以最好copy一份php.ini重起名字(本项目叫php-composer.ini)去掉xdebug选项,本方法只适合windows系统。   
第三方composer均未上传需手动更新,比如composer update xiucaiwu/tp5tool。不会用composer的直接composer update(ps:所有的第三方包都会更新,所以不掌握composer的phper不是好phper)。  

## 在线体验
[点我爽一下](http://thinkadmin.91-t.com/ "爽一下")  
账号: guest  
密码: 123456  

## 界面预览

![界面预览](https://gitee.com/bullet/thinkadmin/raw/master/screenshots/20180516182602.png "截图1")
![界面预览](https://gitee.com/bullet/thinkadmin/raw/master/screenshots/20180516182636.png "截图2")
![界面预览](https://gitee.com/bullet/thinkadmin/raw/master/screenshots/20180516182712.png "截图3")

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。
LayUI遵循MIT开源协议发布，并提供免费使用。
ThinkAdmin遵循MIT开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

## 学习交流群

QQ:14977386