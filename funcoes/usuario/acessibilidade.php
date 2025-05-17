<!-- Botão (ícone do boneco) -->
<div id="painelAcessibilidade" class="painel-acessibilidade" style="display: none;">
    <h3>Ferramentas de Acessibilidade</h3>
    <div class="botoes-acessibilidade">
        <button onclick="ajustarFonte(1)">A+</button>
        <button onclick="ajustarFonte(-1)">A-</button>
        <button onclick="escalaCinza()">Escala de cinza</button>
        <button onclick="altoContraste()">Alto contraste</button>
        <button onclick="contrasteNegativo()">Contraste negativo</button>
        <button onclick="fonteLegivel()">Fonte legível</button>
        <button onclick="resetar()">Redefinir</button>
    </div>
</div>

<div id="btnAcessibilidade" class="icone-acessibilidade" title="Acessibilidade">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#333" viewBox="0 0 100 100">
        <path d="M50 .8c5.7 0 10.4 4.7 10.4 10.4S55.7 21.6 50 21.6s-10.4-4.7-10.4-10.4S44.3.8 50 .8zM92.2 32l-21.9 2.3c-2.6.3-4.6 2.5-4.6 5.2V94c0 2.9-2.3 5.2-5.2 5.2H60c-2.7 0-4.9-2.1-5.2-4.7l-2.2-24.7c-.1-1.5-1.4-2.5-2.8-2.4-1.3.1-2.2 1.1-2.4 2.4l-2.2 24.7c-.2 2.7-2.5 4.7-5.2 4.7h-.5c-2.9 0-5.2-2.3-5.2-5.2V39.4c0-2.7-2-4.9-4.6-5.2L7.8 32c-2.6-.3-4.6-2.5-4.6-5.2v-.5c0-2.6 2.1-4.7 4.7-4.7h.5c19.3 1.8 33.2 2.8 41.7 2.8s22.4-.9 41.7-2.8c2.6-.2 4.9 1.6 5.2 4.3v1c-.1 2.6-2.1 4.8-4.8 5.1z"></path>
    </svg>
</div>

<script>
    // Mostra/Oculta painel
    document.getElementById('btnAcessibilidade').addEventListener('click', function() {
        const painel = document.getElementById('painelAcessibilidade');
        painel.style.display = painel.style.display === 'none' ? 'block' : 'none';
    });

    // Fecha se clicar fora
    document.addEventListener('click', function(event) {
        const btn = document.getElementById('btnAcessibilidade');
        const painel = document.getElementById('painelAcessibilidade');
        if (!painel.contains(event.target) && !btn.contains(event.target)) {
            painel.style.display = 'none';
        }
    });

    // Lógica de acessibilidade
    let tamanhoFonte = parseInt(localStorage.getItem('tamanhoFonte')) || 100;
    aplicarPreferencias();

    function ajustarFonte(delta) {
        tamanhoFonte += delta * 10;
        document.body.style.fontSize = tamanhoFonte + '%';
        localStorage.setItem('tamanhoFonte', tamanhoFonte);
    }

    function escalaCinza() {
        document.body.classList.toggle('escala-cinza');
        salvarPreferenciaClasse('escala-cinza');
    }

    function altoContraste() {
        removerClasses(['contraste-negativo', 'escala-cinza']);
        document.body.classList.toggle('alto-contraste');
        salvarPreferenciaClasse('alto-contraste');
    }

    function contrasteNegativo() {
        removerClasses(['alto-contraste', 'escala-cinza']);
        document.body.classList.toggle('contraste-negativo');
        salvarPreferenciaClasse('contraste-negativo');
    }

    function fonteLegivel() {
        document.body.classList.toggle('fonte-legivel');
        salvarPreferenciaClasse('fonte-legivel');
    }

    function resetar() {
        document.body.style.fontSize = '100%';
        tamanhoFonte = 100;
        localStorage.removeItem('tamanhoFonte');
        removerClasses(['escala-cinza', 'alto-contraste', 'contraste-negativo', 'fonte-legivel']);
        localStorage.removeItem('classesAcessibilidade');
    }

    function salvarPreferenciaClasse(classe) {
        const classes = document.body.className.split(' ').filter(c => c.startsWith('escala') || c.includes('contraste') || c === 'fonte-legivel');
        if (document.body.classList.contains(classe)) {
            if (!classes.includes(classe)) classes.push(classe);
        } else {
            const index = classes.indexOf(classe);
            if (index !== -1) classes.splice(index, 1);
        }
        localStorage.setItem('classesAcessibilidade', JSON.stringify(classes));
    }

    function aplicarPreferencias() {
        document.body.style.fontSize = tamanhoFonte + '%';
        const classesSalvas = JSON.parse(localStorage.getItem('classesAcessibilidade')) || [];
        classesSalvas.forEach(classe => {
            document.body.classList.add(classe);
        });
    }

    function removerClasses(classes) {
        classes.forEach(c => document.body.classList.remove(c));
    }
</script>