<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('pay/notify','V1\OrderController@payNotify');
Route::group(['prefix'=>'v1'],function (){
    Route::post('login','V1\WeChatController@login');
    Route::get('product/types','V1\ProductController@getProductTypesTree');
    Route::get('documents','V1\SystemController@getDocuments');
    Route::get('adverts','V1\AdvertController@getAdverts');
    Route::get('recommend/list','V1\ProductController@getRecommendList');
    Route::get('hot/types','V1\ProductController@getHotTypes');
    Route::group(['middleware'=>'checkToken'],function (){
        Route::post('address','V1\WeChatController@createAddress');
        Route::get('addresses','V1\WeChatController@getAddresses');
        Route::get('address','V1\WeChatController@getAddress');
        Route::delete('address','V1\WeChatController@delAddress');
        Route::post('default/address','V1\WeChatController@setDefaultAddress');
        Route::get('default/address','V1\WeChatController@getDefaultAddress');
        Route::post('store/apply','V1\WeChatController@createApply');
        Route::get('store/categories','V1\StoreController@getStoreCategories');
        Route::get('products','V1\ProductController@getProductsApi');
        Route::get('product','V1\ProductController@getProductApi');
        Route::get('product/assesses','V1\ProductController@getProductAssesses');
        Route::get('stock','V1\ProductController@getStock');
        Route::post('cart','V1\ProductController@addCart');
        Route::get('carts','V1\ProductController@getCarts');
        Route::delete('carts','V1\ProductController@delCarts');
        Route::post('order','V1\OrderController@createOrder');
        Route::get('order/express','V1\OrderController@getOrderExpress');
        Route::get('order/confirm','V1\OrderController@confirmOrder');
        Route::post('order/assess','V1\OrderController@assessOrder');
        Route::get('order/cancel','V1\OrderController@cancelOrder');
        Route::get('orders','V1\OrderController@getMyOrders');
        Route::post('pay','V1\OrderController@payOrder');
        Route::post('collect','V1\ProductController@addCollect');
        Route::get('collects','V1\ProductController@getCollects');
        Route::delete('collect','V1\ProductController@delCollect');
        Route::post('proxy/apply','V1\WechatController@addProxyApply');
        Route::post('withdraw/apply','V1\WechatController@addWithdrawApply');
        Route::get('withdraw/applies','V1\WeChatController@getWithdrawApplies');
        Route::get('user/amount','V1\WechatController@getUserAmount');
        Route::get('user/qrcode','V1\WechatController@getUserQrCode');
        Route::get('project/qrcode','V1\ProductController@getProductQrCode');
        Route::post('user/info','V1\WechatController@addUserInfo');
        Route::get('user/info','V1\WechatController@getUserInfo');
        Route::get('proxy/list','V1\WechatController@getProxyList');
        Route::post('proxy/list','V1\WechatController@addProxyList');
        Route::get('brokerages','V1\WechatController@getBrokerageList');
//        Route::get('product/')
    });

});