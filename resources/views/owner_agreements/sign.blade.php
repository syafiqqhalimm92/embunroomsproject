<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Owner Agreement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.7;
            color: #222;
            margin: 30px;
            background: #f7f7f7;
        }

        .container {
            max-width: 950px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
        }

        .signature-box {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        canvas {
            border: 1px solid #bbb;
            background: #fff;
            display: block;
        }

        .success-box {
            padding: 10px;
            border: 1px solid #0a0;
            color: #0a0;
            margin-bottom: 12px;
        }

        .error-box {
            padding: 10px;
            border: 1px solid #a00;
            color: #a00;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="container">

        @if(session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                <strong>There were some errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            {!! $renderedContent !!}
        </div>

        @if(!$ownerAgreement->owner_signature_path)
            <div class="signature-box">
                <h3>Owner Signature</h3>

                <form method="POST" action="{{ route('owner-agreements.sign-submit', $ownerAgreement->sign_token) }}">
                    @csrf

                    <canvas id="signature-pad" width="500" height="180"></canvas>
                    <input type="hidden" name="owner_signature_data" id="owner_signature_data">

                    <div style="margin-top:10px;">
                        <button type="button" onclick="clearSignature()">Clear</button>
                        <button type="submit" onclick="return prepareSignature()">Sign Agreement</button>
                    </div>
                </form>
            </div>
        @else
            <div class="signature-box">
                <h3>Agreement Status: Signed</h3>
                <p>Signed at: {{ optional($ownerAgreement->owner_signed_at)->format('d/m/Y H:i') }}</p>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.getElementById('signature-pad');

        if (canvas) {
            const signaturePad = new SignaturePad(canvas);

            window.clearSignature = function () {
                signaturePad.clear();
            }

            window.prepareSignature = function () {
                if (signaturePad.isEmpty()) {
                    alert('Please provide your signature first.');
                    return false;
                }

                document.getElementById('owner_signature_data').value = signaturePad.toDataURL('image/png');
                return true;
            }
        }
    </script>
</body>
</html>