// public/js/app.js

document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    stateSelect.addEventListener('change', function () {
        const stateId = this.value;

        citySelect.innerHTML = '<option value="">Carregando...</option>';

        if (stateId) {
            fetch(`/api/cities/${stateId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    citySelect.innerHTML = '<option value="">Selecione uma cidade</option>';
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city;
                        option.textContent = city;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar cidades:', error);
                    citySelect.innerHTML = '<option value="">Erro ao carregar</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">Selecione um estado</option>';
        }
    });
});