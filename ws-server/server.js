const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });

let usuariosOnline = new Map();

wss.on('connection', (ws) => {
    // Aqui tu pode substituir por dados do Laravel (ex: ID, nome, etc)
    const idUsuario = Date.now() + Math.random();
    const nomeUsuario = "Usuário_" + Math.floor(Math.random() * 1000);

    usuariosOnline.set(idUsuario, nomeUsuario);

    broadcast();

    ws.on('close', () => {
        usuariosOnline.delete(idUsuario);
        broadcast();
    });

    function broadcast() {
        const msg = JSON.stringify({
            online: usuariosOnline.size,
            usuarios: Array.from(usuariosOnline.values())
        });

        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(msg);
            }
        });
    }
});

console.log("Servidor WebSocket rodando na porta 8080");
