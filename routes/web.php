<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('pattern_alias', '[a-zA-Z0-9\_]+');

Route::get('/', 'IndexController@index')->name('home');


Route::group(['middleware' => 'guest'], function() {
    // Authentication Routes...
    Route::get('/access-to-cpanel', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/access-to-cpanel', 'Auth\LoginController@login');

    Route::group(['prefix' => 'member'], function () {
        Route::get('login', 'Auth\LoginController@showMemberLoginForm')->name('member.login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('create', 'Auth\RegisterController@createMember')->name('member.create');
        Route::post('forgot', 'Auth\ForgotPasswordController@newPassword')->name('member.forgot');
        Route::post('email', 'Auth\RegisterController@matchEmail')->name('match.member.email');
        Route::get('validate/email/{code}', 'Auth\RegisterController@validateEmail')->name('member.validate.email');
    });
});

Route::group(['middleware' => 'auth', 'prefix' => 'cpanel'], function() {
    Route::get('', 'Cpanel\IndexController@index')->name('dashboard');
    Route::post('domains/sudo/report', 'Cpanel\IndexController@domainsSudoReport')->name('domains.sudo.report');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['prefix' => 'static-page', 'namespace' => 'Cpanel'], function () {
        Route::get('list', 'StaticPageController@list')->name('pages.list');
        Route::get('add', 'StaticPageController@add')->name('page.add');

        Route::post('add', 'StaticPageController@create');
        Route::put('sort', 'StaticPageController@sort')->name('pages.sort');
        Route::get('{page}', 'StaticPageController@edit')->name('page.edit');
        Route::put('{page}', 'StaticPageController@update');
        Route::delete('{page}', 'StaticPageController@delete')->name('page.delete');
        Route::get('{page}/descendants', 'StaticPageController@descendants')->name('page.descendants');
    });

    Route::group(['prefix' => 'settings', 'namespace' => 'Cpanel'], function () {
        Route::get('languages', 'LanguagesController@list')->name('settings.languages');
        Route::get('language/add', 'LanguagesController@add')->name('settings.language.add');
        Route::post('language/add', 'LanguagesController@create')->name('settings.language.create');
        Route::put('languages/sort', 'LanguagesController@sort')->name('settings.languages.sort');
        Route::get('languages/{lang}', 'LanguagesController@edit')->name('settings.language.edit');
        Route::put('languages/{lang}', 'LanguagesController@update');
        Route::delete('languages/{lang}', 'LanguagesController@delete')->name('settings.language.delete');

        Route::get('sites', 'SitesController@list')->name('settings.sites');
        Route::get('site/add', 'SitesController@add')->name('settings.site.add');
        Route::post('site/add', 'SitesController@create')->name('settings.site.create');
        Route::get('sites/{site}', 'SitesController@edit')->name('settings.site.edit');
        Route::put('sites/{site}', 'SitesController@update');
        Route::delete('sites/{site}', 'SitesController@delete');
        Route::post('ktdatatable/sites/list', 'SitesController@listForKTDatatable')->name('ktdatatable.settings.sites.list');
    });

    Route::group(['prefix' => 'employees',  'namespace' => 'Cpanel'], function () {
        Route::get('', 'AdminController@list')->name('employees.list');
        Route::get('add', 'AdminController@add')->name('employees.add');
        Route::post('add', 'AdminController@create');
        Route::post('email', 'AdminController@matchEmail')->name('match.email');
        Route::get('{employee}/{tab?}', 'AdminController@manage')->name('employees.manage');
        Route::put('{employee}/{tab?}', 'AdminController@update');
        Route::delete('{employee}', 'AdminController@delete')->name('employees.delete');
    });

    Route::group(['prefix' => 'members',  'namespace' => 'Cpanel'], function () {
        Route::get('', 'MembersController@list')->name('members.list');

        Route::get('{member}/{tab?}', 'MembersController@profile')->name('member.profile');
        Route::put('{member}/{tab?}', 'MembersController@update');
        Route::delete('{member}', 'MembersController@delete');
        Route::post('ktdatatable/partners/list', 'MembersController@partnersListForKTDatatable')->name('ktdatatable.partners.list');
        Route::post('ktdatatable/list', 'MembersController@listForKTDatatable')->name('ktdatatable.members.list');
        Route::post('ktdatatable/{member}/investment', 'MembersController@memberInvestForKTDatatable')->name('ktdatatable.member.investment');

        Route::get('{member}/investment/{id}', 'MembersController@getInvestmentRow')->name('member.investment.row');
        Route::delete('{member}/investment/{id}', 'MembersController@deleteInvestmentRow');
        Route::put('{member}/investment/{id}', 'MembersController@updateInvestmentRow');
    });

    Route::group(['prefix' => 'content', 'namespace' => 'Cpanel'], function () {
        Route::get('articles/list', 'ArticlesController@list')->name('content.articles.list');
        Route::get('article/add', 'ArticlesController@add')->name('content.article.add');
        Route::post('article/add', 'ArticlesController@create');
        Route::get('article/{article}', 'ArticlesController@edit')->name('content.article.edit');
        Route::put('article/{article}', 'ArticlesController@update');
        Route::delete('article/{article}', 'ArticlesController@delete');
        Route::post('ktdatatable/articles/list', 'ArticlesController@listForKTDatatable')->name('ktdatatable.content.articles.list');
        Route::post('article/upload-media/{article}', 'ArticlesController@uploadMedia')->name('content.article.upload.media');
        Route::delete('article/{article}/media/{media}', 'ArticlesController@deleteMedia')->name('content.article.delete.media');
    });


//    Route::group(['prefix' => 'finalsedo', 'namespace' => 'Cpanel'], function () {
//        Route::get('credentials/list', 'FinalSedoController@credentialsList')->name('finalsedo.credentials.list');
//        Route::get('credential/add', 'FinalSedoController@credentialAdd')->name('finalsedo.credential.add');
//        Route::post('credential/add', 'FinalSedoController@credentialCreate');
//        Route::get('credential/{credential}', 'FinalSedoController@credentialEdit')->name('finalsedo.credential.edit');
//        Route::put('credential/{credential}', 'FinalSedoController@credentialUpdate');
//        Route::delete('credential/{credential}', 'FinalSedoController@credentialDelete');
//        Route::post('ktdatatable/credentials/list', 'FinalSedoController@credentialsListKTDatatable')->name('ktdatatable.finalsedo.credentials.list');
//    });
});