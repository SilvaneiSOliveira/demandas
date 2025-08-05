@extends('layouts.app')

@section('content')
<style> 
    .no-loading-page {
        display: none !important;
    }
</style>

<div class="p-6">
    <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-6">PREVENTIVA > Selecione o cliente</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach (['DROGARIA DA GENTE', 'AFORMULA SALVADOR', 'PLUSPHARMA', 'FLORA', 'ELEMENTAR', 'CRIAÇÃO', 'PLANETA', 'SINGULAR SALVADOR', 'SINGULAR VILAS'] as $cliente)
            <button 
                class="bg-gray-500 hover:bg-gray-400 text-white font-medium py-3 px-4 rounded shadow transition duration-200"
                onclick="abrirModal('{{ $cliente }}')">
                {{ $cliente }}
            </button>
        @endforeach
    </div>
</div>

{{-- Modal --}}
<div id="modalPreventiva" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white w-[95%] md:w-[70%] max-h-[90%] overflow-y-auto rounded-xl shadow-lg p-6 relative animate-fade-in">
        
        <!-- Botão de fechar -->
        <button onclick="fecharModal()" class="absolute top-3 right-4 text-gray-400 hover:text-red-600 text-2xl font-bold">&times;</button>
        
        <!-- Título -->
        <h3 id="clienteTitulo" class="text-xl font-semibold text-center mb-6 text-gray-800 uppercase tracking-wide"></h3>

        <!-- Formulário -->
        <form id="formPreventiva" class="space-y-6">
            <div id="conteudoTabelaPreventiva">
                <!-- Tabela será carregada dinamicamente via Ajax -->
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4 mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-medium transition">
                    💾 Salvar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    function abrirModal(cliente) {
        document.getElementById('clienteTitulo').innerText = cliente;
        document.getElementById('modalPreventiva').classList.remove('hidden');

        fetch(`/tombamentos/preventiva/filiais/${encodeURIComponent(cliente)}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('conteudoTabelaPreventiva').innerHTML = html;
            });
    }

    function fecharModal() {
        document.getElementById('modalPreventiva').classList.add('hidden');
    }

    document.getElementById('formPreventiva').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('cliente', document.getElementById('clienteTitulo').innerText);

        fetch('{{ route('preventiva.salvar') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        }).then(response => response.json())
        .then(data => {
            alert('Salvo com sucesso!');
            fecharModal();
        }).catch(error => {
            alert('Erro ao salvar: ' + error.message);
        });
    });
</script>
@endsection
