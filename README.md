<h1><i></i>
<i></i>
register</h1>
<h3>URL</h3>
<p>/api/register</p>
<h3>method</h3>
<p>POST</p>
<h3>parameters</h3>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number<br></td>
<td>18911209450</td>
</tr>
<tr><td>password</td>
<td>string</td>
<td>true</td>
<td>password is at least 6 characters long<br></td>
<td>123456</td>
</tr>
<tr><td>password_confirmation</td>
<td>string</td>
<td>true</td>
<td><br></td>
<td>123456</td>
</tr>
</tbody>
</table>
<h2>return (on succeed)</h2>
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
<hr>
<h1><b>login</b></h1>
<h2>url</h2>
<p>/api/login</p>
<h2>method</h2>
<p>POST</p>
<h2>parameters</h2>
<table width="618" height="126"><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
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
<h2>return (on succeed)<br></h2>
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
<h2><span data-type="object" data-size="2">return (on failed)<br></span>
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
<hr><h1>login by sms/send sms</h1>
<h2>url</h2>
<p>/api/login/sms</p>
<h2>method</h2>
<p>GET</p>
<hr><h1>login by sms/post login</h1>
<h2>url</h2>
<p>/api/login/sms</p>
<h2>method</h2>
<p>POST</p>
<table width="618" height="126"><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody>
<tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone no.</td>
<td>150974</td>
</tr>
<tr><td>token</td>
<td>string</td>
<td>true</td>
<td>verify code sent by sms <br></td>
<td>150974</td>
</tr>
</tbody>
</table>

<hr><h1>cut image<br></h1>
<h2>url</h2>
<p>/api/v1/cut</p>
<h2>method</h2>
<p>POST</p>
<h2>parameters</h2>
<table width="618" height="126"><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>file</td>
<td>string</td>
<td>true</td>
<td>image that user drew<br></td>
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
<h2>url</h2>
<p>/api/v1/bone</p>
<h2>method</h2>
<p>POST</p>
<h2>parameters</h2>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
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
<hr><h1>send reset password verification code<br></h1>
<h2>url</h2>
<p>/password/sms/send</p>
<h2>method<br></h2>
<p>GET</p>
<h2>parameters</h2>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number<br></td>
<td>18911209450</td>
</tr>
</tbody>
</table>
<h2>return (on failed)</h2>
<p><span data-type="object" data-size="3">{<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"success"</span>
:<span class="json_string">false</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"message"</span>
:<span class="json_string">"发送失败"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"data"</span>
:<span data-type="object" data-size="3">{<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"success"</span>
:<span class="json_string">false</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"message"</span>
:<span class="json_string">"账户余额不足"</span>
,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="json_key">"error"</span>
:<span class="json_string">"请充值后重试"</span>
<br>&nbsp;&nbsp;&nbsp;&nbsp; }</span>
<br>}</span>
</p>
<hr><h1>reset password<br></h1>
<h2>url</h2>
<p>/password/reset</p>
<h2>method<br></h2>
<p>POST</p>
<h2>parameters</h2>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number<br></td>
<td>18911209450</td>
</tr>
<tr><td>password</td>
<td>string</td>
<td>true</td>
<td>password is at least 6 characters long<br></td>
<td>123456</td>
</tr>
<tr><td>password_confirmation</td>
<td>string</td>
<td>true</td>
<td><br></td>
<td>123456</td>
</tr>
<tr><td>token</td>
<td>string</td>
<td>true</td>
<td>verification code sent through sms</td>
<td>837572</td>
</tr>
</tbody>
</table>
<p><br></p>
<h2>return (on succeed)</h2>
<p>{"success":true}</p>
<h2>return (on failed)</h2>
{<br>&nbsp;&nbsp;&nbsp; "success":false,<br>&nbsp;&nbsp;&nbsp; "message":"This password reset token is invalid."<br>}
<hr><h1>send sms<br></h1>
<h2>url<br></h2>
<p>/sms/send</p>
<h2>method</h2>
<p>GET</p>
<h2>parameters</h2>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>phone</td>
<td>string</td>
<td>true</td>
<td>phone number<br></td>
<td>18911209450<br></td>
</tr>
<tr><td>content</td>
<td>string</td>
<td>true</td>
<td>the text content<br></td>
<td>您的验证码是223344</td>
</tr>
</tbody>
</table>

<h1>get latest 4 schedules</h1>
<h2>url</h2>
<p>/api/schedules?merchant_id=1</p>
<h2>parameters</h2>
<table><thead><tr><th>name</th>
<th>type</th>
<th>required</th>
<th>description</th>
<th>example</th>
</tr>
</thead>
<tbody><tr><td>merchant_id</td>
<td>string</td>
<td>true</td>
<td></td>
<td></td>
</tr>
</tbody>

</table>
<h2>return</h2>
[<br>&nbsp;&nbsp;&nbsp; {<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "id":4,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "begin":"2017-11-17 00:00:00",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "end":"2017-11-18 00:00:00",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "status":"applying",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "course_id":1,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "merchant_id":1,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "point_id":1,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "created_at":"2017-11-17 15:40:38",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "updated_at":"2017-11-17 15:40:38"<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }<br>&nbsp;&nbsp;&nbsp; ]

