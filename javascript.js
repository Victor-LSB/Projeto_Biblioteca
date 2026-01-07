const campoTitulo = document.getElementById('titulo');
const divSugestoes = document.getElementById('sugestoes');
const campoCapa = document.getElementById('capa_url');
const campoAutor = document.getElementById('autor');
const campoGenero = document.getElementById('genero');

campoTitulo.addEventListener('keyup', function() {
    let busca = campoTitulo.value;

    if (busca.length > 3) {
        fetch(`https://www.googleapis.com/books/v1/volumes?q=intitle:${busca}&maxResults=5`)
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
                            campoCapa.value = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : '';
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
});