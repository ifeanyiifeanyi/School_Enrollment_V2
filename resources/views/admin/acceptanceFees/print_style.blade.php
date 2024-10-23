<style>
    /* General styles */
    .stats-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .stats-card {
        flex: 1;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Print-specific styles */
    @media print {
        /* Reset page margins and ensure white background */
        @page {
            margin: 0.5cm;
            size: A4;
        }

        /* Hide unnecessary elements */
        .main-sidebar,
        .navbar,
        .main-footer,
        .no-print,
        .section-header-button,
        .search-form,
        .action-buttons {
            display: none !important;
        }

        /* Reset main content positioning */
        .main-content {
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
        }

        /* Ensure content takes full width */
        .main-wrapper {
            margin-left: 0 !important;
            padding-left: 0 !important;
            min-height: auto !important;
        }

        /* Report header styling */
        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px 0;
            border-bottom: 2px solid #000;
        }

        .print-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .print-header p {
            font-size: 14px;
            color: #666;
        }

        /* Statistics cards print layout */
        .stats-cards {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            border: 1px solid #ddd;
            padding: 15px;
            page-break-inside: avoid;
        }

        .stats-card {
            border: none;
            box-shadow: none;
            text-align: left;
            background: none !important;
            color: black !important;
        }

        .stats-card h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .stats-card h2 {
            font-size: 20px;
            color: #000;
        }

        /* Table styling for print */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5 !important;
            color: black !important;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9 !important;
        }

        /* Status badges for print */
        .badge {
            border: 1px solid #000;
            padding: 2px 5px;
            font-weight: normal;
            color: #000 !important;
            background: none !important;
        }

        .badge-success::after {
            content: "";
        }

        .badge-warning::after {
            content: "";
        }

        .badge-danger::after {
            content: "";
        }

        /* Ensure table headers repeat on new pages */
        thead {
            display: table-header-group;
        }

        /* Prevent rows from breaking across pages */
        tr {
            page-break-inside: avoid;
        }

        /* Footer styling */
        .print-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        /* Page numbers */
        .page-number:after {
            content: counter(page);
        }

        /* Avoid breaking inside elements */
        .card {
            page-break-inside: avoid;
        }
    }
</style>
