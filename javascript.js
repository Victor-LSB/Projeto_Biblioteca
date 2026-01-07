const campoTitulo = document.getElementById('titulo');
const divSugestoes = document.getElementById('sugestoes');
const campoCapa = document.getElementById('capa_url');
const campoAutor = document.getElementById('autor');
const campoGenero = document.getElementById('genero');

let timer;
campoTitulo.addEventListener('keyup', function() {
    clearTimeout(timer);
    timer = setTimeout(function() {
        let busca = campoTitulo.value.trim();

    if (busca.length > 3) {
        let termoExato = encodeURIComponent(`intitle:${busca}`);
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${termoExato}&printType=books&orderBy=relevance&maxResults=5`)
            .then(res => res.json())
            .then(dados => {
                divSugestoes.innerHTML = '';
                divSugestoes.style.display = 'block';

                if (dados.items) {
                    dados.items.forEach(item => {
                        const p = document.createElement('p');
                        p.textContent = item.volumeInfo.title;
                        p.style.cursor = 'pointer';

                        p.onclick = function() {
                            campoTitulo.value = item.volumeInfo.title;
                            let urlCapa = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : '';
                            urlCapa = urlCapa.replace('zoom=1', 'zoom=5');
                            campoCapa.value = urlCapa;
                            campoAutor.value = item.volumeInfo.authors ? item.volumeInfo.authors.join(', ') : '';
                            campoGenero.value = item.volumeInfo.categories ? item.volumeInfo.categories.join(', ') : '';
                            divSugestoes.style.display = 'none';
                        };
                        divSugestoes.appendChild(p);
                    });
                }
      });
    }  else {
        divSugestoes.style.display = 'none';
    }
    } , 300);
    
}); 