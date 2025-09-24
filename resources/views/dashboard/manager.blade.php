@extends('layouts.dashboard')

@section('title', 'Dashboard do Gerente')

@section('css-files')
    <link rel="stylesheet" href="{{ asset('css/manager/dashboard.css') }}">
@endsection

@section('content')
    <main>
        <section class="dashboard-summary">
            <div class="card">
                <i class="bi bi-people-fill"></i>
                <h3>Alunos Presentes Agora:</h3>
                <p><strong id="liveCounter">{{ $studentsInGym }}</strong></p>
            </div>

            <div class="card">
                <i class="bi bi-person-add"></i>
                <h3>Últimas Matrículas:</h3>
                <ul>
                    @forelse ($recentEnrollments as $subscription)
                        <li>
                            <p><strong>{{ $subscription->user->name }}</strong> -
                                {{ $subscription->created_at->format('d/m/Y') }}
                            </p>
                        </li>
                    @empty
                        <li>
                            <p>Nenhuma matrícula recente.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
                <i class="bi bi-calendar-x"></i>
                <h3>Assinaturas a Vencer:</h3>
                <ul>
                    @forelse ($expiringSubscriptions as $subscription)
                        <li>
                            <p><strong>{{ $subscription->user->name }}</strong> - {{ $subscription->ends_at->format('d/m/Y') }}
                            </p>
                        </li>
                    @empty
                        <li>
                            <p>Nenhuma assinatura próxima ao vencimento.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
                <i class="bi bi-credit-card-2-back-fill"></i>
                <h3>Pagamentos Pendentes:</h3>
                <p><strong>{{ $pendingPayments }}</strong></p>
                <a href="#">Ver Pendências</a>
            </div>

            <div class="card">
                <i class="bi bi-person-check-fill"></i>
                <h3>Melhores da Equipe:</h3>
                <ul>
                    @forelse ($topEmployees as $employee)
                        <li>
                            <p><strong>{{ $employee->name }}</strong> - {{ $employee->total_sales }} Matrículas</p>
                        </li>
                    @empty
                        <li>
                            <p>Nenhum funcionário encontrado.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="card">
                <i class="bi bi-bar-chart-line-fill"></i>
                <h3>Taxa de Ocupação:</h3>
                <p><strong>{{ number_format($occupancyRate, 2) }}%</strong></p>
                <canvas id="occupancyGauge"></canvas>
            </div>
        </section>

        <section class="charts-section">
            <div class="chart-options">
                <label for="intervalo">Intervalo:</label>
                <select id="intervalo">
                    <option value="semana">Última Semana</option>
                    <option value="mes">Último Mês</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="flowChart" aria-label="Gráfico de Fluxo de Alunos"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="flowPeakChart" aria-label="Gráfico de Pico de Horário por Dia"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="flowEnrollmentChart" aria-label="Gráfico de Novas Matrículas vs. Cancelamentos"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="flowRevenueChart" aria-label="Gráfico de Receita Mensal"></canvas>
            </div>
        </section>

        <section class="quick-actions">
            <h2>Ações Rápidas</h2>
            <div class="actions-grid">
                <a href="{{ route('manager.employees.create') }}" class="action-button">
                    <i class="bi bi-person-plus"></i>
                    Cadastrar Funcionário
                </a>
                <a href="{{ route('manager.reports.financial') }}" class="action-button">
                    <i class="bi bi-card-checklist"></i>
                    Gerar Relatório Financeiro
                </a>
                <a href="{{ route('manager.members.communicate') }}" class="action-button">
                    <i class="bi bi-person-lines-fill"></i>
                    Comunicar com Alunos
                </a>
            </div>
        </section>
    </main>
@endsection

@section('js-files')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dailyFlowData = @json($dailyFlowData);
        const flowChartCtx = document.getElementById('flowChart').getContext('2d');
        new Chart(flowChartCtx, {
            type: 'bar',
            data: {
                labels: dailyFlowData.map(item => item.date),
                datasets: [{ label: 'Alunos por Dia', data: dailyFlowData.map(item => item.total_students), backgroundColor: 'rgba(240, 127, 11, 0.6)' }]
            }
        });

        const peakHoursData = @json($peakHoursData);
        const peakHoursCtx = document.getElementById('flowPeakChart').getContext('2d');
        new Chart(peakHoursCtx, {
            type: 'line',
            data: {
                labels: peakHoursData.map(item => `${item.hour}:00`),
                datasets: [{ label: 'Pico de Horário', data: peakHoursData.map(item => item.total_students), backgroundColor: 'rgba(75, 192, 192, 0.6)' }]
            }
        });

        const enrollmentAndChurnData = @json($enrollmentAndChurnData);
        const enrollmentAndChurnCtx = document.getElementById('flowEnrollmentChart').getContext('2d');
        new Chart(enrollmentAndChurnCtx, {
            type: 'line',
            data: {
                labels: enrollmentAndChurnData.map(item => item.date),
                datasets: [
                    { label: 'Novas Matrículas', data: enrollmentAndChurnData.map(item => item.total_enrollments), borderColor: 'rgba(54, 162, 235, 1)', fill: false },
                    { label: 'Cancelamentos', data: enrollmentAndChurnData.map(item => item.total_churn), borderColor: 'rgba(255, 99, 132, 1)', fill: false }
                ]
            }
        });

        const monthlyRevenue = @json($monthlyRevenue);
        const monthlyRevenueCtx = document.getElementById('flowRevenueChart').getContext('2d');
        new Chart(monthlyRevenueCtx, {
            type: 'pie',
            data: {
                labels: monthlyRevenue.map(item => item.month),
                datasets: [{ label: 'Receita Mensal', data: monthlyRevenue.map(item => item.total_revenue), backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'] }]
            }
        });

        const studentsInGym = {{ $studentsInGym }};
        const maxCapacity = {{ $manager->gym->max_capacity ?? 1 }};
        const occupancyRate = (studentsInGym / maxCapacity) * 100;
        const occupancyCtx = document.getElementById('occupancyGauge').getContext('2d');
        new Chart(occupancyCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ocupado', 'Livre'],
                datasets: [{
                    data: [occupancyRate, 100 - occupancyRate],
                    backgroundColor: ['rgba(240, 127, 11, 0.6)', 'rgba(200, 200, 200, 0.2)'],
                    borderColor: ['rgba(240, 127, 11, 1)', 'rgba(200, 200, 200, 0.2)'],
                    borderWidth: 1
                }]
            },
            options: {
                circumference: 180,
                rotation: -90,
                cutout: '80%',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    </script>
@endsection