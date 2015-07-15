<?php

Route::get('statement/aggregate', 'Lockr\Statement\HttpController@aggregate');
Route::get('statement/insert', 'Lockr\Statement\HttpController@insert');
Route::get('statement/void', 'Lockr\Statement\HttpController@void');
