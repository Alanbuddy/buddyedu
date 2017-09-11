# 接口说明

## Authentication

### 参数：
- key 平台设置的密钥key
- nounce 随机字符串,32位以内
- method 要调用的方法(字符串)
- sign 签名

### 加密算法
- 第一步：对参数按照key=value的格式，并按照参数名ASCII字典序排序如下：(如果参数的值为空不参与签名；)
    `temp="method=cut&nouce=ibuaiVcKdpRxk";`
    `sign=MD5(temp);`
- 第二步：拼接密钥：
` temp=temp+"&key=192006250b4c09247ec02edce69f6a2d";`
- 第三步：生成签名(HMAC-SHA256签名方式)：
* sign=hash_hmac("sha256",temp,key).toUpperCase()="6A9...AE16"

### 最终发送的数据：
* method
* nounce
* sign
