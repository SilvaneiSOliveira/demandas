{{-- Modal do Computador --}}
<div id="modalComputador" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]">
    <div class="bg-white w-[95%] md:w-[70%] max-h-[90%] overflow-y-auto rounded-xl shadow-lg relative animate-fade-in">
        
        <!-- Cabeçalho do Modal -->
        <div class="p-6 border-b relative">
            <!-- Botão de fechar -->
            <button onclick="fecharModalComputador()" 
                    class="absolute top-3 right-4 text-gray-400 hover:text-red-600 text-2xl font-bold">&times;
            </button>
            
            <!-- Título -->
            <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="lucide-monitor w-6 h-6 text-cyan-600"></i> 
                Detalhes do Computador
            </h2>
        </div>

        <!-- Conteúdo do Modal -->
        <div class="p-6">
            <form id="formComputador" class="space-y-6">
                @csrf
                <input type="hidden" id="computadorId" name="computador_id">

                <!-- Seção Cliente / Filial -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-3">
                        <i class="lucide-building w-5 h-5 text-indigo-600"></i> 
                        Informações da Empresa
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Cliente --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Cliente <span class="text-red-500">*</span></label>
                            <select id="modalClienteId" name="cliente_id" disabled
                                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                            </select>
                        </div>

                        {{-- Filial --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Filial</label>
                            <select id="modalFilialId" name="filial_id" disabled
                                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Seção Identificação -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-3">
                        <i class="lucide-tag w-5 h-5 text-pink-600"></i> 
                        Identificação
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- TAG --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">TAG <span class="text-red-500">*</span></label>
                            <input type="text" id="modalTag" name="tag" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>

                        {{-- Local --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Local <span class="text-red-500">*</span></label>
                            <input type="text" id="modalLocal" name="local" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>
                </div>

                <!-- Seção Hardware -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-3">
                        <i class="lucide-cpu w-5 h-5 text-green-600"></i> 
                        Hardware
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Processador --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Processador <span class="text-red-500">*</span></label>
                            <input type="text" id="modalProcessador" name="processador" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>

                        {{-- Memória RAM --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Memória RAM <span class="text-red-500">*</span></label>
                            <input type="text" id="modalMemoriaRam" name="memoria_ram" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>

                        {{-- Armazenamento --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Armazenamento <span class="text-red-500">*</span></label>
                            <input type="text" id="modalArmazenamento" name="armazenamento" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>

                        {{-- Sistema Operacional --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Sistema Operacional <span class="text-red-500">*</span></label>
                            <input type="text" id="modalSistemaOperacional" name="sistema_operacional" disabled
                                   class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>
                </div>

                <!-- Seção Observações -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 flex items-center gap-2 mb-3">
                        <i class="lucide-notebook w-5 h-5 text-orange-600"></i> 
                        Observações
                    </h3>
                    <textarea id="modalObservacao" name="observacao" rows="3" disabled
                              class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-cyan-500"></textarea>
                </div>

                {{-- Botões --}}
                <div class="flex space-x-4 mt-6">
                    <button type="button" id="btnEditar" onclick="habilitarEdicao()" 
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded shadow transition duration-200">
                        <i class="lucide-pencil w-5 h-5"></i> Editar
                    </button>
                    <button type="submit" id="btnSalvar" style="display: none;" 
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded shadow transition duration-200">
                        <i class="lucide-save w-5 h-5"></i> Salvar
                    </button>
                </div>
            </form>

            <!-- Uiltima alteração -->
            <div class="mt-6 text-sm text-gray-500 italic border-t pt-3">
                Última alteração feita por
                <span id="modalUsuarioAlteracao" class="font-medium text-gray-700">-</span>
                em
                <span id="modalUltimaAlteracao" class="font-medium text-gray-700">-</span>
            </div>
              
        </div>
    </div>
</div>
