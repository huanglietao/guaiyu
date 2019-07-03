# 项目说明


## 代码风格检测
```shell
./vendor/bin/phpcs --standard=PSR2 --tab-width=4 --encoding=utf-8 --warning-severity=8 --colors app/
```

[phpcs文档](https://github.com/squizlabs/PHP_CodeSniffer/wiki)

## 代码自动格式化
```shell
./vendor/bin/phpcbf --standard=PSR2 app/
```
## 代码规则检测
```shell
./vendor/bin/phpmd app text rules.xml
```

[phpmd文档](https://www.kancloud.cn/bajiao/phpmd/128475)

