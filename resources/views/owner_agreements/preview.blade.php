<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Owner Agreement Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.7;
            color: #222;
            margin: 30px;
        }

        .topbar {
            margin-bottom: 20px;
        }

        .topbar button {
            padding: 8px 14px;
            cursor: pointer;
        }

        .paper {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
        }

        @media print {
            .topbar {
                display: none;
            }

            body {
                margin: 0;
            }

            .paper {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <button type="button" onclick="window.print()">Print</button>
    </div>

    <div class="paper">
        {!! $renderedContent !!}
    </div>

</body>
</html>