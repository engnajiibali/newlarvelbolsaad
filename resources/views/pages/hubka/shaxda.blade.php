<!DOCTYPE html>
<html>
<head>
    <title>Shaxda Hubka Ciidanka Booliiska Soomaaliyeed</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Select2 CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <style>
        /* Global */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background: linear-gradient(90deg, #0d3d6c, #21CBF3);
            color: white;
            padding: 30px 20px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Controls */
        .controls {
            text-align: center;
            margin: 20px 0;
        }
        .controls form {
            display: inline-block;
        }
        .controls select.select2 {
            width: 220px !important;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .controls button {
            padding: 8px 16px;
            margin: 0 5px;
            font-size: 14px;
            font-weight: 600;
            color: white;
            background-color: #0d3d6c;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .controls button:hover {
            background-color: #095191;
        }

        /* Table Card */
        .table-card {
            background: white;
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        th, td {
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        thead th {
            background-color: #0d3d6c;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        td:first-child, th:first-child {
            background-color: #103d6c;
            color: white;
            font-weight: 600;
        }
        td:last-child, th:last-child {
            background-color: #0d3d6c;
            color: white;
            font-weight: 600;
        }

        /* Count coloring */
        .count-zero {
            background-color: #e74c3c;
            color: white;
            font-weight: 600;
        }
        .count-positive {
            background-color: #27ae60;
            color: white;
            font-weight: 600;
        }

        /* Totals row */
        .grand-total-row {
            background-color: #1abc9c;
            color: white;
            font-weight: 700;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 10%;
            left: 15%;
            width: 70%;
            opacity: 0.08;
            z-index: -1;
        }
        .watermark img { width: 100%; }

        /* Print */
        @media print {
            @page { size: landscape; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<header>
    Shaxda Hubka Ciidanka Booliiska Soomaaliyeed
</header>

<div class="controls no-print">
     <button onclick="history.back()">Back</button>
    <form method="get">
        <label for="fadhi"><strong>Filter by Fadhi:</strong></label>
        <select name="fadhi" id="fadhi" class="select2" onchange="this.form.submit()">
            <option value="">-- All --</option>
            @foreach ($allFadhiyada as $fadhi)
                <option value="{{ $fadhi->id }}" {{ $fadhi->id == $selectedFadhi ? 'selected' : '' }}>
                    {{ $fadhi->name }}
                </option>
            @endforeach
        </select>
    </form>
    <button onclick="window.print()">Print</button>
    <button onclick="exportPDF()">Export PDF</button>
    <button onclick="exportExcel()">Export Excel</button>
</div>

<div class="watermark">
    <img src="https://spflogistic.com/application/images/LogoBol.jpeg" alt="Watermark">
</div>

<div class="table-card">

    @php
        $columnTotals = array_fill_keys($items->pluck('ItemId')->toArray(), 0);
        $grandTotal = 0;
    @endphp

    <table id="dataTable">
        <thead>
        <tr>
            <th>Magaca Fadhiyada</th>
            @foreach ($items as $item)
                <th>{{ $item->ItemName }}</th>
            @endforeach
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($fadhiyada as $fadhi)

            @php
                $rowTotal = 0;
                $hasAnyItem = false;

                // Pre-check if any item > 0
                foreach ($items as $item) {
                    $count = $itemCounts[$fadhi->id][$item->ItemId] ?? 0;
                    if ($count > 0) {
                        $hasAnyItem = true;
                    }
                    $rowTotal += $count;
                }
            @endphp

            @if($hasAnyItem)
                <tr>
                    <td>{{ $fadhi->name }}</td>

                    @foreach ($items as $item)
                        @php
                            $count = $itemCounts[$fadhi->id][$item->ItemId] ?? 0;
                            $columnTotals[$item->ItemId] += $count;
                        @endphp

                        <td class="{{ $count == 0 ? 'count-zero' : 'count-positive' }}">
                            {{ $count }}
                        </td>
                    @endforeach

                    <td><strong>{{ $rowTotal }}</strong></td>

                    @php $grandTotal += $rowTotal; @endphp
                </tr>
            @endif

        @endforeach
        </tbody>

        <tfoot>
        <tr class="grand-total-row">
            <th>Total</th>
            @foreach ($items as $item)
                <th>{{ $columnTotals[$item->ItemId] }}</th>
            @endforeach
            <th>{{ $grandTotal }}</th>
        </tr>
        </tfoot>
    </table>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();
});

async function exportPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
    const element = document.body;
    const controls = document.querySelector('.controls');

    controls.style.display = 'none';
    await new Promise(resolve => setTimeout(resolve, 300));

    html2canvas(element, { scale: 2, useCORS: true }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        let heightLeft = pdfHeight;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        heightLeft -= pdf.internal.pageSize.getHeight();

        while (heightLeft > 0) {
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, heightLeft - pdfHeight, pdfWidth, pdfHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();
        }

        controls.style.display = 'block';
        pdf.save('Shaxda_Hubka_Boliska.pdf');
    });
}

function exportExcel() {
    const table = document.getElementById("dataTable");
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(wb, "Shaxda_Hubka_Boliska.xlsx");
}
</script>

</body>
</html>
