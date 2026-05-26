<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Attendance Scanner</title>

    <!-- Bootstrap -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- QR Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Kantumruy Pro', sans-serif;
        }

        body {
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(circle at top left, #2563eb, transparent 30%),
                radial-gradient(circle at bottom right, #7c3aed, transparent 30%),
                linear-gradient(135deg, #020617, #0f172a);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | Floating Blur Background
        |--------------------------------------------------------------------------
        */
        .blur-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: .4;
            z-index: 1;
        }

        .circle1 {
            width: 250px;
            height: 250px;
            background: #3b82f6;
            top: -80px;
            left: -80px;
        }

        .circle2 {
            width: 300px;
            height: 300px;
            background: #8b5cf6;
            bottom: -100px;
            right: -100px;
        }

        /*
        |--------------------------------------------------------------------------
        | Card
        |--------------------------------------------------------------------------
        */
        .scanner-card {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 620px;

            background: rgba(255, 255, 255, 0.06);

            border: 1px solid rgba(255,255,255,.08);

            backdrop-filter: blur(25px);

            border-radius: 35px;

            padding: 35px;

            box-shadow:
                0 10px 50px rgba(0,0,0,.45);

            animation: fadeIn .7s ease;
        }

        .top-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            padding: 8px 18px;

            border-radius: 50px;

            background: rgba(255,255,255,.08);

            color: #cbd5e1;

            font-size: 14px;

            margin-bottom: 20px;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .title {
            color: white;
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 30px;
        }

        /*
        |--------------------------------------------------------------------------
        | Scanner
        |--------------------------------------------------------------------------
        */
        .scanner-wrapper {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            padding: 10px;

            background: rgba(255,255,255,.04);

            border: 1px solid rgba(255,255,255,.08);
        }

        #reader {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
        }

        /*
        |--------------------------------------------------------------------------
        | Scan Line
        |--------------------------------------------------------------------------
        */
        .scan-line {
            position: absolute;
            left: 10%;
            width: 80%;
            height: 3px;

            background: linear-gradient(
                90deg,
                transparent,
                #38bdf8,
                transparent
            );

            box-shadow:
                0 0 15px #38bdf8;

            animation: scanMove 2.5s linear infinite;
        }

        /*
        |--------------------------------------------------------------------------
        | Result Box
        |--------------------------------------------------------------------------
        */
        .result-box {
            margin-top: 25px;
            border-radius: 25px;
            padding: 25px;
            color: white;
            animation: fadeIn .4s ease;
        }

        .success-box {
            background:
                linear-gradient(
                    135deg,
                    rgba(34,197,94,.2),
                    rgba(34,197,94,.08)
                );

            border: 1px solid rgba(34,197,94,.25);
        }

        .error-box {
            background:
                linear-gradient(
                    135deg,
                    rgba(239,68,68,.2),
                    rgba(239,68,68,.08)
                );

            border: 1px solid rgba(239,68,68,.25);
        }

        .loading-box {
            background:
                linear-gradient(
                    135deg,
                    rgba(59,130,246,.2),
                    rgba(59,130,246,.08)
                );

            border: 1px solid rgba(59,130,246,.25);
        }

        .employee-avatar {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: auto;
            margin-bottom: 15px;
        }

        .info-item {
            background: rgba(255,255,255,.04);
            padding: 14px 18px;
            border-radius: 15px;
            margin-bottom: 12px;

            display: flex;
            justify-content: space-between;
        }

        .info-label {
            color: #94a3b8;
        }

        .info-value {
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | Animations
        |--------------------------------------------------------------------------
        */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: .5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes scanMove {
            0% {
                top: 15%;
            }

            50% {
                top: 80%;
            }

            100% {
                top: 15%;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media(max-width: 576px) {

            .scanner-card {
                padding: 22px;
            }

            .title {
                font-size: 28px;
            }

        }
    </style>
</head>

<body>

    <!-- Background -->
    <div class="blur-circle circle1"></div>
    <div class="blur-circle circle2"></div>

    <div class="scanner-card">

        <div class="top-badge">
            <div class="pulse-dot"></div>
            ប្រព័ន្ធស្កេនវត្តមានកំពុងដំណើរការ
        </div>

        <h1 class="title">
            QR Attendance Scanner
        </h1>

        <div class="subtitle">
            សូមបង្ហាញ QR Code របស់អ្នកទៅកាន់កាមេរ៉ា
        </div>

        <!-- Scanner -->
        <div class="scanner-wrapper">

            <div class="scan-line"></div>

            <div id="reader"></div>

        </div>

        <!-- Result -->
        <div id="result-box" class="d-none"></div>

    </div>

    <script>

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const resultBox =
            document.getElementById('result-box');

        /*
        |--------------------------------------------------------------------------
        | Scan Success
        |--------------------------------------------------------------------------
        */
        function onScanSuccess(decodedText) {

            html5QrcodeScanner.clear();

            showLoading();

            axios.post("{{ route('attendance.scan') }}", {

                scan_code: decodedText

            }, {

                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }

            })

            .then(response => {

                let data = response.data;

                showSuccess(data);

                restartScanner();

            })

            .catch(error => {

                let msg = error.response
                    ? error.response.data.message
                    : "មានបញ្ហាបច្ចេកទេស";

                showError(msg);

                restartScanner();

            });
        }

        /*
        |--------------------------------------------------------------------------
        | UI States
        |--------------------------------------------------------------------------
        */
        function showLoading() {

            resultBox.className =
                "result-box loading-box";

            resultBox.innerHTML = `

                <div class="text-center">

                    <div class="spinner-border text-info mb-3"></div>

                    <h5>
                        កំពុងផ្ទៀងផ្ទាត់...
                    </h5>

                </div>

            `;
        }

        function showSuccess(data) {

            resultBox.className =
                "result-box success-box";

            resultBox.innerHTML = `

                <div class="employee-avatar">
                    <i class="bi bi-person-check-fill"></i>
                </div>

                <h4 class="text-center mb-4">
                    ${data.message}
                </h4>

                <div class="info-item">
                    <div class="info-label">ឈ្មោះ</div>
                    <div class="info-value">
                        ${data.employee_name}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">ស្ថានភាព</div>
                    <div class="info-value">
                        ${data.attendance_status}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">ប្រភេទ</div>
                    <div class="info-value">
                        ${data.type}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">ម៉ោង</div>
                    <div class="info-value">
                        ${data.time}
                    </div>
                </div>

            `;
        }

        function showError(msg) {

            resultBox.className =
                "result-box error-box";

            resultBox.innerHTML = `

                <div class="text-center">

                    <div class="mb-3" style="font-size:55px;">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    </div>

                    <h5>${msg}</h5>

                </div>

            `;
        }

        /*
        |--------------------------------------------------------------------------
        | Restart
        |--------------------------------------------------------------------------
        */
        function restartScanner() {

            setTimeout(() => {

                resultBox.classList.add('d-none');

                html5QrcodeScanner.render(
                    onScanSuccess,
                    onScanFailure
                );

            }, 3000);
        }

        /*
        |--------------------------------------------------------------------------
        | Failure
        |--------------------------------------------------------------------------
        */
        function onScanFailure(error) {
            // silent
        }

        /*
        |--------------------------------------------------------------------------
        | Start Scanner
        |--------------------------------------------------------------------------
        */
        let html5QrcodeScanner = new Html5QrcodeScanner(

            "reader",

            {
                fps: 10,

                qrbox: {
                    width: 260,
                    height: 260
                }
            },

            false
        );

        html5QrcodeScanner.render(
            onScanSuccess,
            onScanFailure
        );

    </script>

</body>

</html>