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

/**
 * Category
 */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

/**
 * Subcategory
 */
Route::resource('subcategories', 'Subcategories\SubcategoriesController', ['except' => ['create', 'edit']]);

/**
 * Product
 */
Route::resource('products', 'Product\ProductController', ['except' => ['create', 'edit']]);
