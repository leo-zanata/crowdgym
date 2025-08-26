document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('graficoHorasTreino').getContext('2d');

    const tabelaHorasSemanal = new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: ['Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado', 'Domingo'],
            datasets: [{
                label: 'Horas Treinadas',
                data: [], 
                backgroundColor: '#FFF9F3',
                borderColor: '#f57419',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const atualizarGrafico = async () => {
        try {
            const resposta = await fetch('../php/aluno/obter_horas_semanal.php');
            const dados = await resposta.json();

            if (Array.isArray(dados)) {
                tabelaHorasSemanal.data.datasets[0].data = dados;
                tabelaHorasSemanal.update();
            } else {
                console.error("Erro ao carregar os dados do gráfico:", dados);
            }
        } catch (erro) {
            console.error("Erro na requisição:", erro);
        }
    };

    atualizarGrafico();
    setInterval(atualizarGrafico, 60000); // Atualiza o gráfico a cada 60 segundos
});
