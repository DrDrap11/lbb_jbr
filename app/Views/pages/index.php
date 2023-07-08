<?= $this->extend('layout/Layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Total User -->
    <?php if (session()->get('role') == 'superadmin') : ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Users</h4>
                    </div>
                    <div class="card-body"><?= $user ?></div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <!-- Kantor Cabang -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-building"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Kantor Cabang</h4>
                </div>
                <div class="card-body"><?= $cabang ?></div>
            </div>
        </div>
    </div>
</div>
<!-- Baris Kedua -->
<div class="row">
    <!-- Data Kolektibilitas -->
    <div class="col-lg">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">Laporan Kolektibilitas -
                    <div class="dropdown d-inline">
                        <label for="bulan">Pilih Bulan:</label>
                        <select name="bulan" id="bulan">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                            <!-- Tambahkan opsi bulan lainnya -->
                        </select>
                    </div>
                </div>
                <div class="card-stats-items">
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="kategori-lancar">-</div>
                        <div class="card-stats-item-label">Lancar</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="kategori-diragukan">-</div>
                        <div class="card-stats-item-label">Diragukan</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="kategori-macet">-</div>
                        <div class="card-stats-item-label">Macet</div>
                    </div>
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <i class="fa-solid fa-rupiah-sign" style="color: #ffffff;"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Kolektibilitas Keseluruhan</h4>
                </div>
                <div class="card-body" id="kategori-total">
                    -
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Menangkap perubahan pilihan bulan
                    $('#bulan').change(function() {
                        // alert( this.value );
                        // Ambil nilai bulan yang dipilih
                        var bulan = $(this).val();

                        // Kirim permintaan AJAX ke server
                        $.ajax({
                            url: `${base_url}dashboard`, // Ganti dengan URL yang sesuai ke controller Anda
                            type: 'POST',
                            data: {
                                bulan: bulan
                            },
                            success: function(response) {
                                console.log(response);
                                // Tampilkan hasil select bulan pada kontainer
                                // $('#hasil-select').html(response);
                                var data = JSON.parse(response);
                                let total = 0;
                                data.forEach(item => {
                                    console.log(item);
                                    total += parseFloat(item?.total_dana);
                                    $(`#kategori-${item?.kategori}`).html(item?.total_dana != 0 ? formatRupiah(item?.total_dana) : '-');
                                });
                                $('#kategori-total').html(total != 0 ? formatRupiah(total) : '-');

                                function formatRupiah(number) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(number);
                                }
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
    <!-- Data Mutasi -->
    <div class="col-lg">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">Laporan Mutasi -
                    <div class="dropdown d-inline">
                        <label for="bulan">Bulan </label>
                        <select name="bulanm" id="bulanmut">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                            <!-- Tambahkan opsi bulan lainnya -->
                        </select>
                    </div>
                </div>
                <div class="card-stats-items">
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="sisa_pinjaman_akhir_bulan_lalu">-</div>
                        <div class="card-stats-item-label">Sisa Pinjaman</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="dipinjamkan_dalam_bulan_laporan">-</div>
                        <div class="card-stats-item-label">Dipinjamkan</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="cicilan_bulan_dalam_bulan_laporan">-</div>
                        <div class="card-stats-item-label">Cicilan</div>
                    </div>
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <!-- <i class="fas fa-dollar-sign"></i> -->
                <i class="fa-solid fa-rupiah-sign" style="color: #ffffff;"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Mutasi Keseluruhan</h4>
                </div>
                <div class="card-body" id="kategorimut-totalmut">
                    -
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Menangkap perubahan pilihan bulan
                    $('#bulanmut').change(function() {
                        // alert( this.value );
                        // Ambil nilai bulan yang dipilih
                        var bulan = $(this).val();

                        // Kirim permintaan AJAX ke server
                        $.ajax({
                            url: `${base_url}dashboard`, // Ganti dengan URL yang sesuai ke controller Anda
                            type: 'POST',
                            data: {
                                bulanmut: bulan
                            },
                            success: function(response) {
                                console.log(response);
                                // Tampilkan hasil select bulan pada kontainer
                                // $('#hasil-select').html(response);
                                var data = JSON.parse(response);
                                let total = 0;
                                data.forEach(item => {
                                    console.log(item);
                                    total += parseFloat(item?.total_dana);
                                    $("#" + item?.kategori).html(item?.total_dana != 0 ? formatRupiah(item?.total_dana) : '-');
                                });
                                $('#kategorimut-totalmut').html(total != 0 ? formatRupiah(total) : '-');

                                function formatRupiah(number) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(number);
                                }
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>
<!-- Baris Ketiga -->
<div class="row">
    <!-- Data Liabilitas -->
    <div class="col-lg">
        <div class="card card-statistic-2">
            <div class="card-stats">
                <div class="card-stats-title">Laporan Liabilitas -
                    <div class="dropdown d-inline">
                        <label for="bulan">Bulan </label>
                        <select name="bulanlia" id="bulanlia">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                            <!-- Tambahkan opsi bulan lainnya -->
                        </select>
                    </div>
                </div>
                <div class="card-stats-items scroll-x">
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="tabungan_desa">-</div>
                        <div class="card-stats-item-label">Tabungan Desa</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="simpanan_wajib">-</div>
                        <div class="card-stats-item-label">Simpanan Wajib</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="simasya_tapel">-</div>
                        <div class="card-stats-item-label">Simasya Tapel</div>
                    </div>
                    <div class="card-stats-item">
                        <div class="card-stats-item-count" id="tabanas_pmk">-</div>
                        <div class="card-stats-item-label">Tabanas PMK</div>
                    </div>
                </div>
            </div>
            <div class="card-icon shadow-primary bg-primary">
                <!-- <i class="fas fa-dollar-sign"></i> -->
                <i class="fa-solid fa-rupiah-sign" style="color: #ffffff;"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Liabilitas Keseluruhan</h4>
                </div>
                <div class="card-body" id="kategori-totalia">
                    -
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    // Menangkap perubahan pilihan bulan
                    $('#bulanlia').change(function() {
                        // alert( this.value );
                        // Ambil nilai bulan yang dipilih
                        var bulan = $(this).val();

                        // Kirim permintaan AJAX ke server
                        $.ajax({
                            url: `${base_url}dashboard`, // Ganti dengan URL yang sesuai ke controller Anda
                            type: 'POST',
                            data: {
                                bulanlia: bulan
                            },
                            success: function(response) {
                                console.log(response);
                                // Tampilkan hasil select bulan pada kontainer
                                // $('#hasil-select').html(response);
                                var data = JSON.parse(response);
                                let total = 0;
                                data.forEach(item => {
                                    console.log(item);
                                    total += parseFloat(item?.total_dana);

                                    $("#" + item?.keterangan).html(item?.total_dana != 0 ? formatRupiah(item?.total_dana) : '-');
                                });
                                $('#kategori-totalia').html(total != 0 ? formatRupiah(total) : '-');

                                function formatRupiah(number) {
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(number);
                                }
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>
<!-- Baris Keempat Bar Chart -->
<div class="row">
    <!-- Bar Chart Neraca -->
    <div class="col-lg-6">
        <div class="card p-">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <canvas id="myChart"></canvas>
            <script>
                var labels = <?php echo json_encode($label); ?>;
                var chartData = <?php echo json_encode($chartData); ?>;
                var categories = <?php echo json_encode(array_values($categories)); ?>;
                var months = <?php echo json_encode($months); ?>;
                var dataset = [];
                var categoryColors = [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                ];
                // Initialize the dataset array
                for (var i = 0; i < categories.length; i++) {
                    dataset.push({
                        label: categories[i],
                        data: [],
                        backgroundColor: categoryColors[i % categoryColors.length],
                    });
                }
                // Populate the dataset with data
                for (var i = 0; i < chartData.length; i++) {
                    var dataPoint = chartData[i];
                    var categoryIndex = categories.indexOf(dataPoint.category);
                    var monthIndex = months.indexOf(dataPoint.month);
                    dataset[categoryIndex].data[monthIndex] = dataPoint.amount;
                }
                // Create the bar chart
                var ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: dataset,
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Neraca Saldo',
                            },
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true,
                                },
                            },
                        }
                    },
                });
            </script>
        </div>
    </div>
    <!-- Bar Chart Laba -->
    <div class="col-lg-6">
        <div class="card p-2">
            <canvas id="labaChart"></canvas>
            <script>
                var labels = <?php echo json_encode($label); ?>;
                var chartData = <?php echo json_encode($chartLaba); ?>;
                var categories = <?php echo json_encode(array_values($categoriesLaba)); ?>;
                var months = <?php echo json_encode($monthsLaba); ?>;
                var dataset = [];
                var categoryColors = [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                ];
                // Initialize the dataset array
                for (var i = 0; i < categories.length; i++) {
                    dataset.push({
                        label: categories[i],
                        data: [],
                        backgroundColor: categoryColors[i % categoryColors.length],
                    });
                }
                // Populate the dataset with data
                for (var i = 0; i < chartData.length; i++) {
                    var dataPoint = chartData[i];
                    var categoryIndex = categories.indexOf(dataPoint.category);
                    var monthIndex = months.indexOf(dataPoint.month);
                    dataset[categoryIndex].data[monthIndex] = dataPoint.amount;
                }
                // Create the bar chart
                var ctx = document.getElementById('labaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: dataset,
                    },
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Laba',
                            },
                            scales: {
                                x: {
                                    stacked: true,
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true,
                                },
                            },
                        }
                    },
                });
            </script>
        </div>
    </div>
</div>
<?= $this->endSection() ?>