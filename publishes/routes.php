<?php

Route::group([
    'prefix' => 'pages',
    'namespace' => 'Terranet\Pages',
], function () {
    Route::get('{slug}.html', [
        'as' => 'pages.show',
        'uses' => 'PagesController@show',
    ]);
});