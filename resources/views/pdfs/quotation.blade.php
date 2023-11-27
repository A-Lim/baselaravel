<html>
    <head>
        <style>
            /* @font-face {
                font-family: 'Inter';
                src: {{ public_path('/fonts/inter/Inter-Regular.ttf') }} format("truetype");
                font-weight: 400;
                font-style: normal;
            }

            @font-face {
                font-family: 'Inter';
                src: {{ public_path('/fonts/inter/Inter-Bold.ttf') }}format("truetype");
                font-weight: 700;
                font-style: bold;
            } */
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            html {
                font-family: 'Inter', sans-serif;
                font-size: 14px;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 108px;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 44px;
            }

            h1 { 
                font-size: 18px;
                margin: 0;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 92px;

                padding: 16px 2cm 0 2cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;

                padding: 16px 2cm;
            }

            #page-number::after {
                content: "Page " counter(page);
            }

            table {
                border-collapse:separate;
            }

            td {
                vertical-align: top;
                padding-bottom: 8px;
            }

            hr {
                margin: 16px 0;
                height: 1px;
                border: 0;
                background-color: gray;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <h1 style="display:block; margin: 0 0 2px 0; font-weight :bold;">NLY COATING <small><b>(001772499-W)</b></small></h1>
                        <small style="margin: 0">
                            No 83, Jalan Harmoni 6, Off Jalan Sg Putus,</br>
                            Taman Sg. Pinang, 4200 Klang, Selangor</br>
                        </small>
                        <small style="display:block; margin-top: 4px">T/F: <a style="margin-right: 12px;" href="tel:03-3358 3800">03-3358 3800</a>E: <a href="mailto:nlycoating@gmail.com">nlycoating@gmail.com</a></small>
                    </td>
                    <td style="text-align: right; vertical-align: bottom">
                        <small>NLY/Q/DCSB/232004</small>
                    </td>
                </tr>
            </table>
        </header>

        <footer style="display:flex; justify-content:space-between; align-items:flex-end;">
            <table style="width: 100%">
                <tr>
                    <td>
                        <small>NLY/Q/DCSB/232004</small>
                    </td>
                    <td style="text-align: right">
                        <small id="page-number"></small>
                    </td>
                </tr>
            </table>
        </footer>

        <hr />
        <main>
            <div style="text-align:center; margin-bottom: 22px;">
                <h1 style="display:inline-block; margin-top: 0; border-bottom: 1px solid black">QUOTATION</h1>
            </div>
            
            <table style="width: 100%">
                <tr>
                    <td style="width: 10%;">To:</td>
                    <td colspan="3">
                        <strong style="display:block;">
                            DE CARPENTERS BUILDERS (M) SDN BHD (1280566-W)
                        </strong>
                        <span>No. 45, Jalan Apollo U5/188, Bandar Pinggiran Subang, Seksyen U5, 40150 Shah Alam, Selangor.</span>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%">Tel:</td>
                    <td style="width:35%"><a href="tel:016-238 8278">016-238 8278</a></td>
                    <td style="width:20%">Quotation No:</td>
                    <td style="width:30%">NLY/Q/DCSB/232004</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><a href="mailto:chris@testmail.com">chris@testmail.com</a></td>
                    <td>Date:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Attn:</td>
                    <td colspan="3">Chris</td>
                </tr>
                <tr>
                    <td>Re:</td>
                    <td colspan="3">
                        <strong>
                            TO SUPPLY & APPLY SUZUKA STRATO SATIN TEXTURE PAINT @ SHOPLOT PEARLPOINTSHOPPING CENTRE
                        </strong>
                    </td>
                </tr>
            </table>

            <hr />

            <div>
                
            </div>
        </main>
    </body>
</html>