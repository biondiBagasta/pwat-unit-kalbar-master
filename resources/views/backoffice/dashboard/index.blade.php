@extends('backoffice.backoffice_components.body')

@section('page-title')
Dashboard
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <div class="card-toolbar">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon3">
                        <i class="las la-search fs-2"></i>
                    </span>
                    <input type="text" placeholder="Filter Berdasarkan Tanggal..."
                    class="form-control" id="filterKeuanganDate"
                    aria-describedby="basic-addon3" />
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div id="financeChart"></div>
    </div>
</div>
@endsection


@section("script")
<script type="text/javascript">

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function formatTanggalIndonesia(date) {
            const tanggal = new Date(date);

            const bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];

            return `${tanggal.getDate()} ${bulan[tanggal.getMonth()]} ${tanggal.getFullYear()}`;
        }

        function formatDateMD(date) {
            const bulan = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des'
            ];

            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');

            return `${day} ${bulan[d.getMonth()]}`;
        }

        // Bagian Chart Keuangan
        $("#filterKeuanganDate").flatpickr({
            mode: "range",
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    let startDate = selectedDates[0]; // JS Date object
                    let endDate   = selectedDates[1]; // JS Date object

                    // Format to your desired string (already formatted by dateFormat)
                    let start = instance.formatDate(startDate, "Y-m-d");
                    let end   = instance.formatDate(endDate, "Y-m-d");

                    getFinanceChart(start, end)
                }
            }
        });

        const financeChart = Highcharts.chart('financeChart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Laporan Keuangan'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                title: {
                    text: 'Nilai (Rupiah)'
                }
            },
            series: [],
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
        });

        function getFinanceChart(startDate = null, endDate = null) {
            $.ajax({
                url: "{{ route('dashboard.finance-chart') }}",
                data: {
                    "start_date": startDate,
                    "end_date": endDate
                },
                type: "POST",
                cache: false,
                success: function(data) {
                    const mappedCategories = data.categories.map(function(d, index) {
                        return formatDateMD(d)
                    });

                    const subtitle = `Dari Tanggal ${formatTanggalIndonesia(data.start_date)} S/D ${formatTanggalIndonesia(data.end_date)}`

                    // Update subtitle
                    financeChart.setSubtitle({
                        text: subtitle
                    }, false);

                    // Update categories
                    financeChart.xAxis[0].setCategories(
                        mappedCategories,
                        false
                    );

                    // Hapus series lama
                    while (financeChart.series.length > 0) {
                        financeChart.series[0].remove(false);
                    }

                    // Tambahkan series dari response
                    data.data.forEach(function(series) {
                        financeChart.addSeries({
                            name: series.name,
                            data: series.data,
                            color: series.name === 'Pengeluaran' ? '#dc3545' : '#198754'
                        }, false);
                    });

                    // Render ulang chart
                    financeChart.redraw();
                }
            })
        }

        getFinanceChart()

    });
</script>
@endsection
