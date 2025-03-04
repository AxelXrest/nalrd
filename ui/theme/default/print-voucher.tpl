<!DOCTYPE html>
<html>
<head>
    <title>{$_title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{$_theme}/images/favicon.ico">
    <!-- Bootstrap CSS for responsive layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Common styles for both web and print */
        body, td, th {
            font-size: 12px;
            font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
        }

        /* Styles for the voucher container */
        .voucher-container {
            width: 22%; /* Set the width */
            height: 250px; /* Set the height */
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
            margin: 0 10px 10px 0;
            position: relative;
            overflow: hidden; /* Ensure the image doesn't overflow the container */
            background-color: #f5f5f5; /* Add a background color to fill any remaining space */
        }

        /* Styles for the voucher background image */
        .voucher-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the container */
        }

        /* Additional styles for non-print view */
        #printable {
            font-size: 0;
            margin-bottom: 10px;
        }

        /* Styles for the text inside .voucher-container */
        .voucher-container > div {
            color: black; /* Text color white */
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 18px;
            text-align: center; /* Center align text */
        }

        .voucher-container > h3 {
            color: white; /* Text color white */
            font-weight: bold;
            margin-top: -5px;
            font-size: 28px;
            text-align: center;
        }

        /* Styles for the price at the top right */
        .voucher-price {
            position: absolute;
            top: 3px;
            right: 10px;
            color: black; /* Text color white */
            font-weight: bold;
            font-size: 18px;
            margin-top: 20%; /* Adjust margin-top as needed */
        }

        /* Styles specific to print */
        @media print {
            body {
                size: auto;
                margin: 0;
                box-shadow: 0;
            }

            page[size="A4"] {
                margin: 0;
                size: auto;
                box-shadow: 0;
            }

            .page-break {
                display: block;
                page-break-before: always;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            /* Adjust styles for printing */
            .voucher-container {
                width: 18% !important; /* Adjust as needed */
                height: 10vh !important;
                font-size:4px !important;
                margin: 3;
                margin-bottom: 20px; /* Add space between vouchers */
                float: left;
            }

            /* Styles for the text inside .voucher-container */
        .voucher-container > div {
            color: black; /* Text color white */
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 9px;
            text-align: center; /* Center align text */
        }

        .voucher-container > h3 {
            color: white; /* Text color white */
            font-weight: bold;
            margin-top: -5px;
            font-size: 16px;
            text-align: center;
        }

        /* Styles for the price at the top right */
        .voucher-price {
            position: absolute;
            top: 3px;
            right: 10px;
            color: black; /* Text color white */
            font-weight: bold;
            font-size: 9px;
            margin-top: 20%; /* Adjust margin-top as needed */
        }

        .under{
            font-size: 6px;
        }
        }
    </style>
</head>
<body>
    <center>
        <button type="button" style="background:green; color:white; padding:10px; border-radius:10px" id="actprint"
            class="btn btn-default btn-sm no-print">{$_L['Click_Here_to_Print']}</button><br>
        <hr>
    </center>
    <br>

    <div id="printable">
        <hr>
        {foreach $v as $vs}
            <!-- Wrap each voucher in a container -->
            <div class="voucher-container">
                <img src="everest.jpg" alt="Background Image">
                <div style="position: absolute; bottom: 3px; left: 10px;"> {$vs['name_plan']}</div>
                <div style="position: absolute;left:30%; top: 50%; transform: translate(-50%, -50%);"><u class="under">Username & Password</u> <br>{$vs['code']}</div>
                <div class="voucher-price">
                    Rs. {$vs['price']}
                </div>
            </div>
        {/foreach}
    </div>

    <!-- Bootstrap JS for responsive behavior -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // initiate layout and plugins
        document.getElementById('actprint').addEventListener('click', function() {
            window.print();
        });
    });
</script>

</body>
</html>
