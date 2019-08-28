<h1 align="center"> vop </h1>

<p align="center"> a sdk for vop demo.</p>


## 安装

```shell
$ composer require agegg/vop -vvv
```

## 在 LARAVEL 中使用

在 Laravel 中配置写在 config/services.php 中：

```
.
.
.
'vop' => [
   'appKey' => env('VOP_API_APPKEY'),
    'appSecret' => env('VOP_API_APPSECRET'),
],
.
.
```



然后在 .env 中配置 VOP_API_APPKEY和VOP_API_APPSECRET：

```
VOP_API_APPKEY=xxxxxxxxxxxxxxxxxxxxx
VOP_API_APPSECRET=xxxxxxxxxxxxxxxxxxxxx
```

#### 示例

```
.   
.
.
public function test()
{
	$vopclient = VopClient::connection();
    $req = new GenByGoodsIdRequest;
	$req->setChanTag('chanTag');
	$req->setRequestId('requestId');
	$req->setGoodsList(['6918179815364186628','6917925588049298498']);
	$resp = $vopclient->execute($req);
	dd($resp);
}
.
.
.
```

## License

MIT