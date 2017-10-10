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
` sign=hash_hmac("sha256",temp,key).toUpperCase()="6A9...AE16"`

### 最终发送的数据：
* method
* nounce
* sign


<h1><i></i>
<i></i>
register</h1>
<h3>URL</h3>
<p>/api/register</p>
<h3>method</h3>
<p>POST</p>
<h3>parameters</h3>
<table width="618" height="126"><thead><tr><td>name</td>
<td>type</td>
<td>required</td>
<td>description</td>
<td valign="top"><br></td>
<td>example</td>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number<br></td>
<td valign="top"><br></td>
<td>18911209450</td>
</tr>
<tr><td>password</td>
<td>string</td>
<td>true</td>
<td>password length is at least 6 characters long<br></td>
<td valign="top"><br></td>
<td>123456</td>
</tr>
<tr><td>password_confirmation</td>
<td>string</td>
<td>true</td>
<td><br></td>
<td valign="top"><br></td>
<td>123456</td>
</tr>
</tbody>
</table>
<h2>return (when succeed)</h2>
<p><span data-type="object" data-size="2">{<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"success"</span>
:<span class="json_string">true</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"data"</span>
:<span data-type="object" data-size="1">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"user"</span>
:<span data-type="object" data-size="6">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"name"</span>
:<span class="json_string">"b"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"phone"</span>
:<span class="json_string">"16207833295"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"api_token"</span>
:<span class="json_string">"3badafb6-86a0-3829-b9b2-4cffd080e2e6"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"updated_at"</span>
:<span class="json_string">"2017-10-10 15:38:38"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"created_at"</span>
:<span class="json_string">"2017-10-10 15:38:38"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"id"</span>
:<span class="json_number">9</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;}</span>
<span data-type="object" data-size="2"></span>
</p>
<hr><h1><b>login</b>
<br></h1>
<h3>URL</h3>
<p>/api/login</p>
<h3>method</h3>
<p>POST</p>
<h3>parameters</h3>
<table width="618" height="126"><thead><tr><td>name</td>
<td>type</td>
<td>required</td>
<td>description</td>
<td>example</td>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number</td>
<td>18911209450</td>
</tr>
<tr><td>password</td>
<td>string</td>
<td>true</td>
<td>password length is at least 6 characters long<br></td>
<td>123456</td>
</tr>
</tbody>
</table>
<h2>return (when succeed)<br></h2>
<p><span data-type="object" data-size="2">{<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"success"</span>
:<span class="json_string">true</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"data"</span>
:<span data-type="object" data-size="1">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"user"</span>
:<span data-type="object" data-size="9">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"id"</span>
:<span class="json_number">8</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"name"</span>
:<span class="json_string">"b"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"email"</span>
:<span class="json_string">null</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"created_at"</span>
:<span class="json_string">"2017-10-10 15:15:07"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"updated_at"</span>
:<span class="json_string">"2017-10-10 15:15:07"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"api_token"</span>
:<span class="json_string">"fa6f5d71-0055-3284-8aca-6a1f6b78868f"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"phone"</span>
:<span class="json_string">"12312341237"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"avatar"</span>
:<span class="json_string">""</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="json_key">"wx"</span>
:<span class="json_string">null</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }</span>
<br>&nbsp;}</span>
</p>
<h2><span data-type="object" data-size="2">return (when failed)<br></span>
</h2>
<p><span data-type="object" data-size="2">{<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"message"</span>
:<span class="json_string">"The given data was invalid."</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"errors"</span>
:<span data-type="object" data-size="1">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"phone"</span>
:<span data-type="array" data-size="1">[<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_string">"These credentials do not match our records."</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }</span>
<br>}</span>
</p>
<p><span data-type="object" data-size="2"><br></span>
</p>
<hr><h1>cut image<br></h1>
<h3>URL</h3>
<p>/api/v1/cut</p>
<h3>method</h3>
<p>POST</p>
<h3>parameters</h3>
<table width="618" height="126"><thead><tr><td>name</td>
<td>type</td>
<td>required</td>
<td>description</td>
<td>example</td>
</tr>
</thead>
<tbody><tr><td>file</td>
<td>string</td>
<td>true</td>
<td>image that user drawed<br></td>
<td><br></td>
</tr>
<tr><td>api_token</td>
<td>string</td>
<td>true</td>
<td>a string token<br></td>
<td>1509a743-cd29-38fb-867c-c2cc42b84b3d<br></td>
</tr>
</tbody>
</table>
<hr><h1>get bone and segments<br></h1>
<h3>URL</h3>
<p>/api/v1/bone</p>
<h3>method</h3>
<p>POST</p>
<h3>parameters</h3>
<table width="618" height="126"><thead><tr><td>name</td>
<td>type</td>
<td>required</td>
<td>description</td>
<td>example</td>
</tr>
</thead>
<tbody><tr><td>file</td>
<td>string</td>
<td>true</td>
<td>the image that's been cut<br></td>
<td><br></td>
</tr>
<tr><td>animal</td>
<td>string</td>
<td>true</td>
<td>the animal that user draws<br></td>
<td></td>
</tr>
<tr><td>api_token</td>
<td>string</td>
<td>true</td>
<td>a string token<br></td>
<td>1509a743-cd29-38fb-867c-c2cc42b84b3d<br></td>
</tr>
</tbody>
</table>

