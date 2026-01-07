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
                        const div = document.createElement('div');
                        div.className = 'sugestao-item';
                      
                        const info = item.volumeInfo;
                        const capa = info.imageLinks ? info.imageLinks.thumbnail.replace('zoom=1', 'zoom=5') : '';
                        const ano = info.publishedDate ? ` (${info.publishedDate.substring(0, 4)})` : 'N/A';

                        div.innerHTML = `
                            <img src="${capa}" style="width: 40px; height: 60px; object-fit: cover;">
                            <div class="sugestao-texto">
                                <strong>${info.title}</strong>${ano}<br>
                                <em>${info.authors ? info.authors.join(', ') : 'Autor Desconhecido'}</em>
                            </div>
                        `;
                        divSugestoes.appendChild(div);

                        div.onclick = function() {
                            campoTitulo.value = info.title;
                            let urlCapa = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : '';
                            urlCapa = urlCapa.replace('zoom=1', 'zoom=5');
                            campoCapa.value = urlCapa;
                            campoAutor.value = item.volumeInfo.authors ? item.volumeInfo.authors.join(', ') : '';
                            campoGenero.value = item.volumeInfo.categories ? item.volumeInfo.categories.join(', ') : '';
                            divSugestoes.style.display = 'none';
                        };
                        divSugestoes.appendChild(div);
                    });
                }
      });
    }  else {
        divSugestoes.style.display = 'none';
    }
    } , 300);
    
}); 