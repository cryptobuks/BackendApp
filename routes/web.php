<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return "Ok";
});

Route::get('api/getData', ['middleware' => 'cors', function () {
    return " {\"id\": \"1\", \"label\": \"JSP\"}";
}]);

Route::post('api/novedad', ['middleware' => 'cors', function (Request $request) {
    $controller = new \App\Http\Controllers\NovedadController();
    return $controller->saveNovedad($request);
}]);

/*Route::get('/acuerdopago/llenar_acuerdo/{id}', [
    'as' => 'acuerdopago.llenar_acuerdo',
    'uses' => 'ControladorAcuerdoPago@llenar_acuerdo'
]);*/




