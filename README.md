# Vop for laravel


## laravel
### 安装
`composer require agegg/vop`
### 配置
* 在config/app.php中的providers数组中添加`Agegg\VopClient\VopClientServiceProvider::class,`
* 在config/app.php中的aliases数组中添加`'VopClient' => Agegg\VopClient\Facades\VopClient::class,`
* 执行 `php artisan vendor:publish --provider="Agegg\VopClient\VopClientServiceProvider"` 生成配置文件
* 编辑.env文件，设置Vop_APP_KEY,Vop_APP_SECRET
### 示例代码
```php
use TopClient;
use TopClient\request\TbkItemGetRequest;

$vopclient = VopClient::connection();
$req = new GenByGoodsIdRequest;
$req->setGoodsIdList(['6918179815364186628','6917925588049298498']);
$req->setChanTag('chanTag');
$req->setRequestId('requestId');
$resp = $vopclient->execute($req);
dd($resp);
```
