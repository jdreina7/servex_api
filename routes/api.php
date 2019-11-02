<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * Roles
 */
Route::resource('roles', 'Role\RoleController', ['except' => ['create', 'edit']]);

/**
 * Users
 */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

/**
 * Clients
 */
Route::resource('clients', 'Client\ClientController', ['except' => ['create', 'edit']]);
Route::resource('clients.categories', 'Client\ClientCategoryController', ['only' => ['index']]);
Route::resource('clients.products', 'Client\ClientProductController', ['only' => ['index']]);
// Route::resource('clients.subcategories', 'Client\ClientSubcategoryController', ['only' => ['index']]);

/**
 * Category
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
Route::resource('categories.subcategories', 'Category\CategorySubcategoryController', ['only' => ['index']]);
Route::resource('categories.clients', 'Category\CategoryClientController', ['only' => ['index']]);

/**
 * Subcategory
 */
Route::resource('subcategories', 'Subcategory\SubcategoryController', ['except' => ['create', 'edit']]);
Route::resource('subcategories.categories', 'Subcategory\SubcategoryCategoryController', ['only' => ['index']]);
Route::resource('subcategories.products', 'Subcategory\SubcategoryProductController', ['only' => ['index']]);

/**
 * Product
 */
Route::resource('products', 'Product\ProductController', ['except' => ['create', 'edit']]);
Route::resource('products.clients', 'Product\ProductClientController', ['only' => ['index']]);
Route::resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index']]);
Route::resource('products.subcategories', 'Product\ProductSubcategoryController', ['only' => ['index']]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');