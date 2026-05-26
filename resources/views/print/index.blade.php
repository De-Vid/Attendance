<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>បោះពុម្ពកាតបុគ្គលិក - {{ $employee->user->name ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Moul:wght@400&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
    :root {
        --primary-blue: #0d2c6c;
        --light-blue: #1982c4;
        --dark-bg: #14171a;
        --gray-text: #6c757d;
    }

    body {
        font-family: 'Inter', 'Noto Sans Khmer', sans-serif;
        background-color: #eef2f7;
        margin: 0;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    /* តំបន់បង្ហាញកាតសងខាង */
    .cards-container {
        display: flex;
        gap: 50px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* ទំហំស្តង់ដារអន្តរជាតិ CR80 (ស្មើនឹង 85.6mm x 54mm) គុណនឹងជញ្ជីង Pixel ឌីជីថល */
    .id-card {
        width: 324px;
        height: 514px;
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 15px 35px rgba(13, 44, 108, 0.12);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-sizing: border-box;
        background-color: #fff;
    }

    /* ==================== ផ្នែកខាងមុខ (FRONT SIDE) ==================== */
    .front-card .header-shape-dark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 165px;
        background: var(--primary-blue);
        clip-path: polygon(0 0, 100% 0, 100% 75%, 0% 100%);
        z-index: 1;
    }

    .front-card .header-shape-light {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 178px;
        background: var(--light-blue);
        clip-path: polygon(0 0, 100% 0, 100% 88%, 0% 100%);
        z-index: 0;
    }

    .logo-area {
        position: absolute;
        top: 25px;
        left: 25px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        /* ធ្វើឱ្យជ្រុងមូលតិចៗមើលទៅទាន់សម័យ */
        overflow: hidden;
        /* លាក់រាល់ផ្នែករូបភាពណាដែលលយចេញក្រៅប្រអប់ */
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        /* ប្រសិនបើឡូហ្គោមានផ្ទៃខាងក្រោយថ្លា (PNG) */
    }

    .logo-icon-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* រក្សារូបរាងដើមរបស់ឡូហ្គោមិនឱ្យទាញខូចទ្រង់ទ្រាយ និងបង្ហាញពេញទំហំប្រអប់ */
    }

    .logo-text {
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.5px;
        color: #ffffff;
    }

    .back-card .logo-text {
        color: #0d2c6c;
    }

    /* ស្ថាបត្យកម្មរូបថតកាតអាជីព */
    .photo-container {
        position: absolute;
        top: 110px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }

    .photo-border-gap {
        padding: 4px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

.emp-photo{
    width: 110px;
    height: 130px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid var(--light-blue);
    background: #f4f6f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.emp-photo img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}

    /* ព័ត៌មានខាងមុខ */
    .front-details {
        margin-top: 260px;
        text-align: center;
        padding: 0 28px;
    }

    .emp-name {
        font-size: 20px;
        font-weight: bold;
        color: #0f172a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .emp-rank {
        font-size: 12px;
        font-weight: 600;
        color: var(--light-blue);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .info-table {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
        margin-top: -10px;
    }

    .info-table td {
        padding: 4px 0;
        vertical-align: middle;
    }

    .label-cell {
        width: 65px;
        text-align: left;
        color: var(--gray-text);
        font-weight: 500;
    }

    .dots-cell {
        width: 15px;
        text-align: center;
        color: var(--gray-text);
    }

    .value-cell {
        text-align: left;
        color: #1e293b;
        font-weight: 600;
    }

    /* រលកបាតក្រោម និង QR Code ផ្នែកខាងមុខ */
    .front-footer-light {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 85px;
        background: var(--light-blue);
        clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
        z-index: 0;
    }

    .front-footer-dark {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 70px;
        background: var(--primary-blue);
        clip-path: polygon(0 35%, 100% 0, 100% 100%, 0 100%);
        z-index: 1;
    }

    .qr-wrapper {
        position: absolute;
        bottom: 16px;
        right: 20px;
        z-index: 10;
        background: #ffffff;
        padding: 6px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ==================== ផ្នែកខាងក្រោយ (BACK SIDE) ==================== */
    .back-card {
        background: var(--dark-bg);
    }

    .back-card .header-shape-white {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: #ffffff;
        clip-path: polygon(0 0, 100% 0, 100% 65%, 0% 100%);
        z-index: 1;
    }

    .back-card .header-shape-blue {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 112px;
        background: var(--light-blue);
        clip-path: polygon(0 0, 100% 0, 100% 75%, 0% 100%);
        z-index: 0;
    }

    .back-content {
        margin-top: 125px;
        padding: 0 25px;
    }

    .section-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--light-blue);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
    }

    .terms-list {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
        font-size: 11px;
        color: #94a3b8;
    }

    .terms-list li {
        position: relative;
        padding-left: 14px;
        margin-bottom: 6px;
        line-height: 1.5;
        text-align: justify;
    }

    .terms-list li::before {
        content: "▶";
        position: absolute;
        left: 0;
        top: 1px;
        color: var(--light-blue);
        font-size: 8px;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        color: #cbd5e1;
    }

    .contact-item i {
        color: var(--light-blue);
        font-size: 12px;
        width: 14px;
    }

    /* រលកបាតក្រោម និង Barcode ផ្នែកខាងក្រោយ */
    .back-footer-light {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 85px;
        background: var(--light-blue);
        clip-path: polygon(0 0, 100% 30%, 100% 100%, 0 100%);
        z-index: 0;
    }

    .back-footer-dark {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 70px;
        background: var(--primary-blue);
        clip-path: polygon(0 0, 100% 35%, 100% 100%, 0 100%);
        z-index: 1;
    }

    .barcode-wrapper {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        background: #ffffff;
        padding: 6px 12px;
        border-radius: 6px;
        text-align: center;
        width: 200px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .barcode-lines {
        background: linear-gradient(90deg, #000 2px, transparent 2px, #000 3px, transparent 5px, #000 6px, transparent 6px, #000 9px, transparent 11px, #000 12px) repeat-x;
        height: 20px;
        width: 100%;
    }

    .barcode-text {
        font-family: 'Courier New', Courier, monospace;
        font-size: 9px;
        color: #000000;
        margin-top: 3px;
        font-weight: bold;
        letter-spacing: 2px;
    }

    /* ==================== PRINT CONFIGURATION ==================== */
    @media print {
        body {
            background-color: #ffffff;
            padding: 0;
            margin: 0;
        }

        .no-print {
            display: none !important;
        }

        .cards-container {
            gap: 0;
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin: 0;
            padding-top: 20mm;
        }

        .id-card {
            box-shadow: none;
            border: 1px solid #e2e8f0;
            page-break-inside: avoid;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* កំណត់ទំហំទំព័រឱ្យត្រូវនឹងកាតស្តង់ដារ */
        @page {
            size: A4 landscape;
            margin: 0;
        }
    }
    </style>
</head>

<body>

    <div class="container text-center mb-4 no-print">
        <button onclick="window.print()" class="btn btn-primary px-4 py-2 rounded-pill shadow fw-bold me-2"
            style="background-color: #0d2c6c; border: none;">
            <i class="bi bi-printer-fill me-1"></i> បោះពុម្ពកាតឥឡូវនេះ
        </button>
    </div>

    <div class="cards-container">

        <div class="id-card front-card">
            <div class="header-shape-light"></div>
            <div class="header-shape-dark"></div>

            <div class="logo-area">
                <div class="logo-icon-box"><img src="/img/IMG_6603-removebg-preview.png" alt=""></div>
                <span class="logo-text">J.Y.PARK CO.,LTD</span>
            </div>

            <div class="photo-container">
                <div class="photo-border-gap">
                    <div class="emp-photo">
                        <img src="{{ asset('uploads/employees/'.$employee->user->image) }}" alt="Employee Photo">
                    </div>
                </div>
            </div>

            <div class="front-details">
                <div class="emp-name">{{ $employee->user->name ?? 'N/A' }}</div>
                <div class="emp-rank">{{ $employee->user->position->name ?? 'N/A' }}</div>

                <table class="info-table">
                    <tr>
                        <td class="label-cell">ID No</td>
                        <td class="dots-cell">:</td>
                        <td class="value-cell">{{ $employee->staff_id }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Phone</td>
                        <td class="dots-cell">:</td>
                        <td class="value-cell text-secondary">{{ $employee->user->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Email</td>
                        <td class="dots-cell">:</td>
                        <td class="value-cell text-secondary">{{ $employee->user->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Birth Date</td>
                        <td class="dots-cell">:</td>
                        <td class="value-cell text-secondary">{{ $employee->user->birth_date ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <div class="front-footer-light"></div>
            <div class="front-footer-dark"></div>
            <div class="qr-wrapper">
                {!! QrCode::size(60)->margin(0)->generate($employee->scan_code) !!}
            </div>
        </div>

        <div class="id-card back-card">
            <div class="header-shape-blue"></div>
            <div class="header-shape-white"></div>

            <div class="logo-area">
                <div class="logo-icon-box"><img src="/img/IMG_6603-removebg-preview.png" alt=""></div>
                <span class="logo-text">J.Y.PARK CO.,LTD</span>
            </div>

            <div class="back-content">
                <div class="section-title">Terms And Conditions</div>
                <ul class="terms-list">
                    <li>កាតនេះប្រើប្រាស់សម្រាប់តែសម្គាល់ខ្លួនក្នុងក្រុមហ៊ុនតែប៉ុណ្ណោះ។</li>
                    <li>ក្នុងករណីបាត់បង់ សូមរាយការណ៍ទៅកាន់ផ្នែករដ្ឋបាលជាបន្ទាន់។</li>
                    <li>សូមរក្សាទុកកាតនេះឱ្យបានល្អនិងជៀសវាងការធ្វើឱ្យឆ្កូតផ្ទៃកូដស្កេន។</li>
                </ul>

                <div class="section-title">Information</div>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <span>{{ $employee->user->email ?? 'admin@company.com' }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-globe"></i>
                        <span>www.company.com</span>
                    </div>
                    <div class="contact-item align-items-start">
                        <i class="bi bi-geo-alt-fill mt-1"></i>
                        <span>រាជធានីភ្នំពេញ, ព្រះរាជាណាចក្រកម្ពុជា</span>
                    </div>
                </div>
            </div>

            <div class="back-footer-light"></div>
            <div class="back-footer-dark"></div>

            <div class="barcode-wrapper">
                <div class="barcode-lines"></div>
                <div class="barcode-text">PZN - {{ $employee->staff_id }}</div>
            </div>
        </div>

    </div>

    <script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
    }
    </script>
</body>

</html>