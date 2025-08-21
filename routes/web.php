<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\DemandaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\GraficoController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PreventivaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\RelatorioAnaliticoController;
use App\Http\Controllers\ContatoFilialController;
use App\Http\Controllers\ContatoController;


Auth::routes();

Route::post('/debug-contato-filial', function(Request $request) {
    dd([
        'rota' => 'debug-contato-filial',
        'dados' => $request->all(),
        'url' => $request->url()
    ]);
});

Route::get('/dashboard/data', [App\Http\Controllers\DashboardController::class, 'getData'])->name('dashboard.data');
Route::middleware('auth')->group(function () {

    
    Route::get('/', function () {return redirect()->route('home');})->name('root');
    
    Route::resource('clientes', ClienteController::class);
    Route::resource('filiais', FilialController::class);
    Route::resource('demandas', DemandaController::class);
    Route::resource('users', UserController::class);
    Route::resource('preventivas', PreventivaController::class);
    

    Route::get('/dashboard', [DashboardController::class, 'graficos']);
    Route::put('/demandas/{id}/resolucao', [DemandaController::class, 'atualizarResolucao'])->name('demandas.atualizarResolucao');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/relatorios/exportar/pdf', [RelatorioController::class, 'exportarPdf'])->name('relatorios.exportar.pdf');
    Route::get('/relatorios/ver-pdf', [RelatorioController::class, 'visualizarPdf'])->name('relatorios.ver_pdf');
    Route::get('/dashboard/contadores', [DashboardController::class, 'contadores'])->name('dashboard.contadores');
    Route::get('/dashboard/ultimas', [DashboardController::class, 'ultimasDemandas'])->name('dashboard.ultimas');
    
   
// Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('relatorios.dashboard');
        Route::get('/create', [RelatorioController::class, 'create'])->name('relatorios.create');
        Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');
        Route::get('/graficos', [GraficoController::class, 'index'])->name('relatorios.graficos');
        Route::get('/exportar-pdf', [RelatorioController::class, 'exportarPdf'])->name('relatorios.exportar.pdf');
        Route::get('/exportar-excel', [RelatorioController::class, 'exportarExcel'])->name('relatorios.exportar.excel');
        Route::get('/analitico', [RelatorioAnaliticoController::class, 'index'])->name('relatorios.analitico');
       
});

//Contatos Filiais
Route::prefix('contatos-filial')->name('contatos_filial.')->group(function () {
    Route::post('/', [App\Http\Controllers\ContatoFilialController::class, 'store'])->name('store');
    Route::get('/{contato}/edit', [App\Http\Controllers\ContatoFilialController::class, 'edit'])->name('edit');
    Route::put('/{contato}', [App\Http\Controllers\ContatoFilialController::class, 'update'])->name('update');
    Route::delete('/{contato}', [App\Http\Controllers\ContatoFilialController::class, 'destroy'])->name('destroy');
});

//Contatos
       Route::prefix('contatos')->group(function () {
       Route::post('/', [App\Http\Controllers\ContatoController::class, 'store'])->name('contatos.store');
       Route::get('/{contato}/edit', [App\Http\Controllers\ContatoController::class, 'edit'])->name('contatos.edit');
       Route::put('/{contato}', [App\Http\Controllers\ContatoController::class, 'update'])->name('contatos.update');
       Route::delete('/{contato}', [App\Http\Controllers\ContatoController::class, 'destroy'])->name('contatos.destroy');
});



// Tombamentos
    Route::prefix('tombamentos')->group(function () {
        Route::get('/preventivas', [PreventivaController::class, 'index'])->name('tombamentos.preventivas');
        Route::get('/computadores', function () {return view('tombamentos.computadores');})->name('tombamentos.computadores');
        Route::post('/preventiva/salvar', [PreventivaController::class, 'salvar'])->name('preventiva.salvar');
        Route::get('/preventiva/filiais/{cliente}', [PreventivaController::class, 'filiais'])->name('preventiva.filiais');
});

// Anexos
    Route::prefix('demandas')->group(function () {
        Route::post('{id}/anexos', [AnexoController::class, 'salvar'])->name('anexos.salvar');
        Route::get('{id}/anexos', [AnexoController::class, 'listar'])->name('anexos.listar');
        Route::get('anexo/download/{anexo}', [AnexoController::class, 'download'])->name('anexos.download');
        Route::delete('anexo/{anexo}', [AnexoController::class, 'remover'])->name('anexos.remover');
        Route::post('/demandas/{id}/anexar', [AnexoController::class, 'anexar'])->name('demanda.anexar');

});
 
});
    Route::get('/filiais', [FilialController::class, 'index'])->name('filiais.index');
    Route::put('/demandas/{id}/status', [DemandaController::class, 'atualizarStatus'])->name('demandas.atualizarStatus');
    Route::get('/filiais-por-cliente/{clienteId}', function ($clienteId) {
    return \App\Models\Filial::where('cliente_id', $clienteId)->get();
});

    Route::get('/home', function () {return view('home');})->name('home');


// Rota de teste opcional
    Route::get('/teste', function () {return view('teste');
 });


require __DIR__.'/auth.php';
