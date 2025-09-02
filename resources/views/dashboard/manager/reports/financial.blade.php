@extends('layouts.dashboard')

@section('title', 'Relatório Financeiro')

@section('content')
        <h1>Relatório Financeiro</h1>
        <div class="report-actions">
            <a href="{{ route('manager.reports.financial.export_csv') }}" class="button">Exportar para CSV</a>
            <a href="{{ route('manager.reports.financial.export_pdf') }}" class="button">Exportar para PDF</a>
        </div>
        <section class="summary-metrics">
            <div class="card">
                <h2>Receita Total</h2>
                <p><strong>R$ {{ number_format($totalRevenue, 2, ',', '.') }}</strong></p>
            </div>
            <div class="card">
                <h2>Assinaturas Ativas</h2>
                <p><strong>{{ $activeSubscriptions }}</strong></p>
            </div>
            <div class="card">
                <h2>Assinaturas Canceladas</h2>
                <p><strong>{{ $canceledSubscriptions }}</strong></p>
            </div>
            <div class="card">
                <h2>Pagamentos Pendentes</h2>
                <p><strong>{{ $pendingPayments }}</strong></p>
            </div>
        </section>

        <section class="monthly-revenue-chart">
            <h2>Receita Mensal (Últimos 6 Meses)</h2>
            <div class="chart-container">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </section>

        <section class="detailed-report">
            <h2>Detalhes da Receita Mensal</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyRevenue as $revenue)
                        <tr>
                            <td>{{ $revenue->month }}</td>
                            <td>R$ {{ number_format($revenue->total, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
@endsection

@section('js-files')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyRevenueData = @json($monthlyRevenue);
        const monthlyRevenueLabels = monthlyRevenueData.map(item => item.month);
        const monthlyRevenueTotals = monthlyRevenueData.map(item => item.total);

        const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyRevenueLabels,
                datasets: [{
                    label: 'Receita Mensal',
                    data: monthlyRevenueTotals,
                    backgroundColor: 'rgba(240, 127, 11, 0.6)',
                    borderColor: 'rgba(240, 127, 11, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection