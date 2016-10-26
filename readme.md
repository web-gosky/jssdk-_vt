# Vitabee New Open

基于Laravel构建，用于维他蜜open平台。

核心开发可参考[Laravel](http://laravelacademy.org/laravel-docs-5_2)开发文档。  
业务开发可参考[Vitabee-Docs](http://git.vitabee.cn/department/technology/wikis/home)开发文档。  

--------

# 路由说明

# -------- 无授权 --------  
## 认证服务回调地址  
http://test.open.vitabee.cn/vitabee/wechatauth/gettoken  

## 测试地址  
http://test.open.vitabee.cn/vitabee/test  
http://test.open.vitabee.cn/vitabee/test/nologin  

--------

# -------- 授权 --------  
## 分享页  
http://test.open.vitabee.cn/vitabee/share?upr_id=7552&is_share=1  

## 分享页--点赞接口  
http://test.open.vitabee.cn/vitabee/share/like  
* 参数[upr_id]: upr_id  
* 返回[data.result_code]:(1=成功),(0=已助力),(-1=操作太频繁),(-2=每天只能点赞一次),(-3=活动已过期)

## 绑定手机号页面
http://test.open.vitabee.cn/vitabee/wechatauth/bindcellphone  

## 绑定手机页--发送验证码接口
http://test.open.vitabee.cn/vitabee/wechatauth/sendcode  
* 参数[cellphone]: 手机号  

## 绑定手机页--验证并绑定手机号接口
http://test.open.vitabee.cn/vitabee/wechatauth/checkcode  
* 参数[cellphone]: 手机号  
* 参数[code]: 验证码  

## 添加小孩页面  
http://test.open.vitabee.cn/vitabee/wechatauth/addchild  

## 添加小孩页面--保存小孩信息接口  
http://test.open.vitabee.cn/vitabee/wechatauth/savechild  
* 参数[nickname]: 昵称  
* 参数[birthday]: 生日（字符串格式yyyy-MM-dd）  
* 参数[gender]: 性别（1=男，2=女）  

--------

# -------- 授权并验证小孩 --------  
## 首页
http://test.open.vitabee.cn/vitabee/index  

## 首页--获取里程碑接口  
http://test.open.vitabee.cn/vitabee/index/activitydetail
* 无参数   

## 首页--获取精选接口&榜单接口  
http://test.open.vitabee.cn/vitabee/index/activityessences
* 无参数   

## 总榜奖励说明页面  
http://test.open.vitabee.cn/vitabee/document/ranktopall  

## 周榜奖励说明页面  
http://test.open.vitabee.cn/vitabee/document/ranktopweek  

## 奖励说明页面
http://test.open.vitabee.cn/vitabee/document/rewards  

## 文件上传页  
http://test.open.vitabee.cn/vitabee/media/index  
## 文件上传页--媒体文件上传接口
http://test.open.vitabee.cn/vitabee/media/upload  
* 参数[media_type]: 媒体类型[图片:image]/[语音:sound]  
* 参数[media_id]: 微信上传多媒体文件返回的media_id（即JSSDK中上传媒体文件时回调中的server_id）  

----
copyright vitabee.cn
