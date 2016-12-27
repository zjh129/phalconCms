#开发须知
phalconCms搭建cms框架

###ide智能提示
```
git clone --depth=1 https://github.com/phalcon/phalcon-devtools.git
```
然后将/ide/stubs/Phalcon目录导入到ide中的library中，新建项目是选中此library即可智能提示phalcon代码。

###将引入谷歌的资源改成引入国内站的资源，否则会加载缓慢
更改方法：用sublime text 搜索public目录下的关键字googleapis，然后全部替换为useso，这样就可以提升页面响应速度了，否则加载奇慢无比。

###cdn资源站
在此网站上搜索对于资源引入到文件即可，无需在本地导入文件。
http://www.bootcdn.cn/

###composer换源
http://pkg.phpcomposer.com/